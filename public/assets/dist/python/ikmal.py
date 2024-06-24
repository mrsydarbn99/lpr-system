import cv2
import torch
from super_gradients.training import models
import numpy as np
import math

# cap = cv2.VideoCapture("../Videos/ORIGINAL_drowning2.mp4")
cap = cv2.VideoCapture(0) #USE WEBCAM FROM OBS
device = torch.device("cuda:0") if torch.cuda.is_available() else torch.device("cpu")
# model = models.get('yolo_nas_s', pretrained_weights="coco").to(device)
model = models.get('yolo_nas_s', num_classes=3, checkpoint_path="../Weight/ckpt_best_S_250.pth").to(device)
count = 0
classNames = ["Drowning", "Swimming", "WithFloating"]
color_map = {
    "Drowning": (0, 0, 255),  # Red for "Drowning"
    "Swimming": (0, 255, 0),  # Green for "Swimming"
    "WithFloating": (255, 0, 0)  # Blue for "WithFloating"
}

is_drowning_detected = False  # Flag to track ongoing drowning sound

while True:
    ret, frame = cap.read()
    count += 1
    if ret:
        result = list(model.predict(frame, conf=0.35))[0]
        bbox_xyxys = result.prediction.bboxes_xyxy.tolist()
        confidences = result.prediction.confidence
        labels = result.prediction.labels.tolist()
        for (bbox_xyxy, confidence, cls) in zip(bbox_xyxys, confidences, labels):
            bbox = np.array(bbox_xyxy)
            x1, y1, x2, y2 = bbox[0], bbox[1], bbox[2], bbox[3]
            x1, y1, x2, y2 = int(x1), int(y1), int(x2), int(y2)
            classname = int(cls)
            class_name = classNames[classname]
            conf = math.ceil((confidence * 100)) / 100
            label = f'{class_name}{conf}'
            color = color_map[class_name]
            print(count, " : ", x1, y1, x2, y2)
            t_size = cv2.getTextSize(label, 0, fontScale=1, thickness=2)[0]
            c2 = x1 + t_size[0], y1 - t_size[1] - 3
            cv2.rectangle(frame, (x1, y1), c2, color, -1, cv2.LINE_AA)
            cv2.putText(frame, label, (x1, y1 - 2), 0, 1, [0, 0, 0], thickness=1, lineType=cv2.LINE_AA)
            cv2.rectangle(frame, (x1, y1), (x2, y2), color, 3)

        #     # Check for drowning class and play sound
        #     if class_name == "Drowning":
        #         is_drowning_detected = True
        #         playsound("../Audio/alarm1.mp3")  # Play audio for 3 seconds
        #
        # # Stop audio after 3 seconds if drowning was previously detected
        # if not is_drowning_detected:
        #     is_drowning_detected = False  # Reset flag even if no drowning is detected

        cv2.imshow("Frame", frame)
        if cv2.waitKey(1) & 0xFF == ord('q'):  # Change exit key to 'q'
            break
    else:
        break

cv2.destroyAllWindows()