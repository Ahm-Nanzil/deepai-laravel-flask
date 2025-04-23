# python/sentiment_analysis.py
from textblob import TextBlob
import sys

def analyze_sentiment(text):
    blob = TextBlob(text)
    sentiment = blob.sentiment.polarity
    if sentiment > 0:
        return "Positive"
    elif sentiment < 0:
        return "Negative"
    else:
        return "Neutral"

if __name__ == "__main__":
    text = sys.argv[1]  # Get the input text from command-line arguments
    result = analyze_sentiment(text)
    print(result)
