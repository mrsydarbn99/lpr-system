import mysql.connector
import string
import easyocr
from datetime import datetime


# Establish database connection
db_connection = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="lpr_system"
)
# Initialize the OCR reader
reader = easyocr.Reader(['en'], gpu=False, verbose=False)
db_cursor = db_connection.cursor()

# Mapping dictionaries for character conversion
dict_char_to_int = {'O': '0',
                    'I': '1',
                    'J': '3',
                    'A': '4',
                    'G': '6',
                    'S': '5'}

dict_int_to_char = {'0': 'O',
                    '1': 'I',
                    '3': 'J',
                    '4': 'A',
                    '6': 'G',
                    '5': 'S'}



def license_complies_format(text):
    """
    Check if the license plate text complies with the required format.

    Args:
        text (str): License plate text.

    Returns:
        bool: True if the license plate complies with the format, False otherwise.
    """
    # if len(text) != 7:
    #     return False

    if len(text) != 6 and \
        (text[0] in string.ascii_uppercase or text[0] in dict_int_to_char.keys()) and \
       (text[1] in string.ascii_uppercase or text[1] in dict_int_to_char.keys()) and \
       (text[2] in string.ascii_uppercase or text[2] in dict_int_to_char.keys()) and \
       (text[3] in ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'] or text[3] in dict_char_to_int.keys()) and \
       (text[4] in ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'] or text[4] in dict_char_to_int.keys()) and \
       (text[5] in ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'] or text[5] in dict_char_to_int.keys()):
        return True
    elif len(text) != 7 and \
         (text[0] in string.ascii_uppercase or text[0] in dict_int_to_char.keys()) and \
         (text[1] in string.ascii_uppercase or text[1] in dict_int_to_char.keys()) and \
         (text[2] in string.ascii_uppercase or text[2] in dict_int_to_char.keys()) and \
         (text[3] in ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'] or text[3] in dict_char_to_int.keys()) and \
         (text[4] in ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'] or text[4] in dict_char_to_int.keys()) and \
         (text[5] in ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'] or text[5] in dict_char_to_int.keys()) and \
         (text[6] in ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'] or text[6] in dict_char_to_int.keys()):
        return True
    else:
        return False


def format_license(text):
    """
    Format the license plate text by converting characters using the mapping dictionaries.

    Args:
        text (str): License plate text.

    Returns:
        str: Formatted license plate text.
    """
    # Replace underscores with an empty string
    # text = text.replace('_', '')

    license_plate_ = ''
    mapping = {0: dict_int_to_char, 1: dict_int_to_char, 4: dict_char_to_int, 5: dict_char_to_int, 6: dict_char_to_int,
               2: dict_int_to_char, 3: dict_char_to_int}
    for j in [0, 1, 2, 3, 4, 5, 6]:
        if text[j] in mapping[j].keys():
            license_plate_ += mapping[j][text[j]]
        else:
            license_plate_ += text[j]

    return license_plate_



def read_license_plate(license_plate_crop):
    """
    Read the license plate text from the given cropped image.

    Args:
        license_plate_crop (PIL.Image.Image): Cropped image containing the license plate.

    Returns:
        tuple: Tuple containing the formatted license plate text and its confidence score.
    """

    detections = reader.readtext(license_plate_crop)

    # Sort detections based on confidence score (score is the third element of each detection tuple)
    detections.sort(key=lambda x: x[2], reverse=True)

    for detection in detections:
        bbox, text, score = detection

        text = text.upper().replace(' ', '')


        if license_complies_format(text):
            return format_license(text), score

    return None, None



def get_car(license_plate, vehicle_track_ids):
    """
    Retrieve the vehicle coordinates and ID based on the license plate coordinates.

    Args:
        license_plate (tuple): Tuple containing the coordinates of the license plate (x1, y1, x2, y2, score, class_id).
        vehicle_track_ids (list): List of vehicle track IDs and their corresponding coordinates.

    Returns:
        tuple: Tuple containing the vehicle coordinates (x1, y1, x2, y2) and ID.
    """
    x1, y1, x2, y2, score, class_id = license_plate

    foundIt = False
    for j in range(len(vehicle_track_ids)):
        xcar1, ycar1, xcar2, ycar2, car_id = vehicle_track_ids[j]

        if x1 > xcar1 and y1 > ycar1 and x2 < xcar2 and y2 < ycar2:
            car_indx = j
            foundIt = True
            break

    if foundIt:
        return vehicle_track_ids[car_indx]

    return -1, -1, -1, -1, -1

# Function to check if the license plate exists in the database
def check_database(license_plate):
    query_residents = "SELECT * FROM residents WHERE plate_num = %s"
    query_non_residents = "SELECT * FROM non_residents WHERE plate_num = %s"

    db_cursor = db_connection.cursor()

    # Check in residents table
    db_cursor.execute(query_residents, (license_plate,))
    result = db_cursor.fetchall()
    if result:
        return 'residents'  # Return 'residents' if found in residents table

    # Check in non_residents table if not found in residents table
    db_cursor.execute(query_non_residents, (license_plate,))
    result = db_cursor.fetchall()
    if result:
        return 'non_residents'  # Return 'non_residents' if found in non_residents table

    return None  # Return None if not found in either table

# Function to update entry time in the database
def update_entry(license_plate, table):
    entry_time = datetime.now().strftime('%Y-%m-%d %H:%M:%S')

    if table == 'residents':
        select_query = "SELECT status FROM residents WHERE plate_num = %s"
        update_query = "UPDATE residents SET entry_time = %s, status = %s WHERE plate_num = %s"
    elif table == 'non_residents':
        select_query = "SELECT status FROM non_residents WHERE plate_num = %s"
        update_query = "UPDATE non_residents SET entry_time = %s, status = %s WHERE plate_num = %s"
    else:
        raise ValueError(f"License plate '{license_plate}' not found in the database.")

    db_cursor = db_connection.cursor()
    
    # Get current status
    db_cursor.execute(select_query, (license_plate,))
    result = db_cursor.fetchone()

    if result:
        current_status = result[0]

        if current_status == 'New':
            new_status = 'In'
        elif current_status == 'In':
            new_status = 'Out'
        else:  # current_status == 'Out'
            new_status = 'In'

        # Update entry time and status
        db_cursor.execute(update_query, (entry_time, new_status, license_plate))
        db_connection.commit()
    else:
        raise ValueError(f"License plate '{license_plate}' not found in the database.")

    db_cursor.close()


