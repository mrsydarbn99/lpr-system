from ultralytics import YOLO
import cv2
import numpy as np
import sys
from datetime import datetime
from sort.sort import *
from util import get_car, read_license_plate, write_csv, check_database, update_entry

# if len(sys.argv) < 2:
#     print("Usage: python process_video.py <path_to_video>")
#     sys.exit(1)

# video_path = sys.argv[1]

# Define the stop signal file path
stop_file = "C:/laragon/www/lpr-system/storage/app/public/stop_scan"

results = {}

mot_tracker = Sort()

# load models
coco_model = YOLO('yolov8s.pt')
license_plate_detector = YOLO('C:/laragon/www/lpr-system/public/assets/dist/python/best.pt')

# load video
# cap = cv2.VideoCapture(video_path)
# cap = cv2.VideoCapture('C:/laragon/www/lpr-system/public/assets/dist/python/video/test6.mp4')

# open camera
cap = cv2.VideoCapture(2)  # 0 for default camera, you can change it to another index if you have multiple cameras

vehicles = [2, 3, 5, 7]

frame_num = -1
ret = True
while ret:
    frame_num += 1
    ret, frame = cap.read()
    if ret:
        try:
            # if frame_nmr > 10:
            #     break
            results[frame_num] = {}
            # detect vehicles
            # pass
            detections = coco_model(frame)[0]
            detections_ = []
            for detection in detections.boxes.data.tolist():
                # print(detections) ############
                x1, y1, x2, y2, score, class_id = detection
                if int(class_id) in vehicles:
                    detections_.append([x1, y1, x2, y2, score])

            # track vehicles
            track_ids = mot_tracker.update(np.asarray(detections_))

            # detect license plates
            license_plates = license_plate_detector(frame)[0]
            for license_plate in license_plates.boxes.data.tolist():
                x1, y1, x2, y2, score, class_id = license_plate

                # assign license plate to car
                xcar1, ycar1, xcar2, ycar2, car_id = get_car(license_plate, track_ids)

                if car_id != -1:

                    # crop license plate
                    license_plate_crop = frame[int(y1):int(y2), int(x1): int(x2), :]

                    # process license plate
                    # license_plate_crop_sharp = cv2.addWeighted(license_plate_crop, 2.3, np.zeros(license_plate_crop.shape, license_plate_crop.dtype), 0, -100)
                    license_plate_crop_gray = cv2.cvtColor(license_plate_crop, cv2.COLOR_BGR2GRAY)
                    _, license_plate_crop_thresh = cv2.threshold(license_plate_crop_gray, 70, 255, cv2.THRESH_BINARY)
                    # th3 = cv2.adaptiveThreshold(license_plate_crop,255,cv2.ADAPTIVE_THRESH_GAUSSIAN_C, cv2.THRESH_BINARY,11,2)

                    # cv2.imshow('original_crop', license_plate_crop)
                    # cv2.imshow('sharp', license_plate_crop_sharp)
                    # cv2.imshow('threshold', license_plate_crop_thresh)
                    # cv2.imshow('Adaptive Gaussian Thresholding', th3)

                    # cv2.waitKey(0)
                    
                    # read license plate number
                    license_plate_text, license_plate_text_score = read_license_plate(license_plate_crop_thresh)

                    clean_license_plate_text = license_plate_text.replace('_', '')

                    if license_plate_text is not None:
                        print(f"Frame {frame_num}: Detected license plate number: {clean_license_plate_text}")
                        results[frame_num][car_id] = {'car': {'bbox': [xcar1, ycar1, xcar2, ycar2]},
                                                    'license_plate': {'bbox': [x1, y1, x2, y2],
                                                                    'text': clean_license_plate_text,
                                                                    'bbox_score': score,
                                                                    'text_score': license_plate_text_score}}
                        # Check against database
                        table = check_database(clean_license_plate_text)
                        if table:
                            print(f"Vehicle with license plate '{clean_license_plate_text}' found in the {table} table in the database.")
                            current_time = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
                            print(f"Vehicle with license plate '{clean_license_plate_text}' is entered at {current_time}.")
                            # Update entry time in the database
                            update_entry(clean_license_plate_text, table)
                            # Save the frame with detected license plate
                            image_path = "C:/laragon/www/lpr-system/storage/app/public/scanned_plate/detected_frame_{}.jpg".format(clean_license_plate_text)
                            cv2.imwrite(image_path, frame)
                            print(f"Frame saved as {image_path}")
                            
                            # Terminate the script successfully
                            sys.exit(0)
                        else:
                            raise Exception(f"Vehicle with license plate '{clean_license_plate_text}' not found in the database.")
                    else:
                        print("Plate text is NONE")

        except Exception as e:
            print(f"Error processing frame {frame_num}: {e}")

    # Display the frame with detections
    cv2.imshow('frame', frame)
    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

# # Release the capture
# cap.release()
# cv2.destroyAllWindows()

# Write results
# write_csv(results, './cubaan.csv')


