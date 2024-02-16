from flask import Flask, request, jsonify
from flask_cors import CORS
import pymysql.cursors

app = Flask(__name__)
CORS(app)  # Enable CORS for all routes

# Connect to the database (replace the connection details with your actual database credentials)
connection = pymysql.connect(host='localhost',
                             user='root',
                             password='',
                             database='health_hub',
                             charset='utf8mb4',
                             cursorclass=pymysql.cursors.DictCursor)

def search(query):
    results = []
    try:
        with connection.cursor() as cursor:
            # Search for distinct entries in the 'diseases' table
            sql = """
                SELECT DISTINCT id, name, description
                FROM diseases
                WHERE LOWER(name) LIKE %s OR LOWER(symptoms) LIKE %s OR LOWER(description) LIKE %s
            """
            params = (f'%{query.lower()}%', f'%{query.lower()}%', f'%{query.lower()}%')
            
            print(f"SQL Query: {cursor.mogrify(sql, params)}")
            
            cursor.execute(sql, params)
            results = cursor.fetchall()

            # Modify results to include a short description
            for result in results:
                result['short_description'] = shorten_description(result['description'])
    except Exception as e:
        print(f"Error searching in the database: {e}")

    return results

def get_disease_details(disease_id):
    try:
        with connection.cursor() as cursor:
            # Retrieve details for the specified disease ID
            sql = "SELECT id, name, description, symptoms, common_tests_procedures, common_tests_procedures_desc, common_medications, common_medications_desc, who_is_at_risk_desc FROM diseases WHERE id = %s"
            cursor.execute(sql, (disease_id,))
            result = cursor.fetchone()

            # No need to modify result
    except Exception as e:
        print(f"Error fetching details from the database: {e}")
        result = None

    return result

def shorten_description(description, max_length=100):
    # Function to create a short description (you can customize the logic)
    if len(description) <= max_length:
        return description
    else:
        return description[:max_length] + "..."

@app.route('/details', methods=['GET'])
def details():
    # Read the search query from the request
    query = request.args.get("id")

    # Handle the case where query is None
    if query is None:
        return jsonify([])

    # Check if the query is an ID for fetching details
    if query.isdigit():
        # Fetch details for the specified disease ID
        disease_details = get_disease_details(query)

        # Return the details in JSON format
        return jsonify(disease_details)
    else:
        # Perform search
        search_results = search(query)

        # Return the search results in JSON format
        return jsonify(search_results)

if __name__ == '__main__':
    app.run(debug=True)