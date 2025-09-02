from flask import Flask, request, jsonify
import time  # Simulating processing time

app = Flask(__name__)

@app.route('/scan', methods=['POST'])
def scan():
    # Get data from the request
    camera_index = request.json.get('camera_index', 2)
    
    # Simulate processing (e.g., video scan)
    time.sleep(5)  # Simulating a delay for scanning process
    result = "Vehicle found!" if camera_index == 0 else "No vehicle detected."
    
    # Return the result
    return jsonify({'output': result})

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)  # Make sure Flask listens on the correct host and port
