from flask import Flask, request, render_template, jsonify
import pandas as pd
import joblib

app = Flask(__name__)

# Load the models
price_model = joblib.load('price_model.pkl')
price_unit_model = joblib.load('price_unit_model.pkl')

# Load the dataset
data = pd.read_csv('data2.csv')
regions = data['region'].unique().tolist()

# Route to fetch unique localities based on the region
@app.route('/get-localities', methods=['POST'])
def get_localities():
    selected_region = request.json.get('region')
    localities = data[data['region'] == selected_region]['locality'].unique().tolist()
    return jsonify({'localities': localities})

# Route for the main page
@app.route('/', methods=['GET', 'POST'])
def index():
    if request.method == 'POST':
        # Collect form data
        bhk = int(request.form['bhk'])
        type_ = request.form['type']
        region = request.form['region']
        status = request.form['status']
        locality = request.form['locality']
        area = float(request.form['area'])
        age = request.form['age']
        
        # Prediction logic
        user_data = pd.DataFrame({
            'bhk': [bhk],
            'type': [type_],
            'region': [region],
            'locality': [locality], 
            'area': [area], 
            'status': [status],
            'age': [age]
        })

        predicted_price = price_model.predict(user_data)
        predicted_price_unit = price_unit_model.predict(user_data)

        # Format the predicted price
        if predicted_price_unit[0] == 1:
            predicted_price_display = round(predicted_price[0] / 1e7, 2)  # Convert to Cr
            predicted_price_unit_display = 'Cr'
        else:
            predicted_price_display = round(predicted_price[0] / 1e5, 2)  # Convert to L
            predicted_price_unit_display = 'L'

        return render_template('result.html', price=predicted_price_display, unit=predicted_price_unit_display)

    return render_template('index.html', regions=regions)

if __name__ == '__main__':
    app.run(debug=True)
