# train_model.py
from sklearn.datasets import load_iris
from sklearn.ensemble import RandomForestClassifier
import joblib

# Load the Iris dataset
data = load_iris()
X = data.data  # Features
y = data.target  # Labels

# Train a simple RandomForest model
model = RandomForestClassifier()
model.fit(X, y)

# Save the model to a file
joblib.dump(model, "model.pkl")
print("Model saved as model.pkl")
