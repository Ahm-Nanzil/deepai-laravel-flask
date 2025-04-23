# ml_api.py
from flask import Flask, request, jsonify
import joblib
import numpy as np

app = Flask(__name__)

# Load the model
try:
    model = joblib.load("model.pkl")  # Ensure the file path is correct
    print("Model loaded successfully!")
except Exception as e:
    print(f"Error loading model: {e}")
    model = None

@app.route("/predict", methods=["POST"])
def predict():
    if model is None:
        return jsonify({"error": "Model not loaded"})

    try:
        # Get JSON data from the request
        data = request.get_json()

        # Extract features and reshape for model input
        features = np.array(data["features"]).reshape(1, -1)

        # Make a prediction using the model
        prediction = model.predict(features)

        # Return the prediction as JSON
        return jsonify({"prediction": prediction.tolist()})
    except Exception as e:
        # Handle errors and return an error message
        return jsonify({"error": str(e)})

if __name__ == "__main__":
    app.run(debug=True)
