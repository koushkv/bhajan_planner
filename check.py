import csv
from datetime import datetime

# Function to format date in yyyy-mm-dd format
def format_date(date_str):
    try:
        # Parse and convert the date string
        date_obj = datetime.strptime(date_str, '%d %b %Y')
        return date_obj.strftime('%Y-%m-%d')
    except ValueError:
        return date_str

# Function to process CSV input
def process_csv(input_file, output_file):
    with open(input_file, mode='r', newline='') as infile, open(output_file, mode='w', newline='') as outfile:
        reader = csv.reader(infile)
        
        # Open the output file and write the processed rows
        with open(output_file, mode='w') as outfile:
            for serial_number, row in enumerate(reader, start=1):
                # Extract the date part
                if len(row) == 3:
                    bhajan, value2, date_str = row
                    formatted_date = format_date(date_str)
                    formatted_row = '"{}","{}","{}","{}"'.format(
                        serial_number,
                        bhajan,
                        value2,
                        formatted_date
                    )
                    outfile.write(formatted_row + '\n')
# File paths
input_file = "C:\\Users\\Koushik\\Downloads\\Bhajansdb.csv"
output_file = "C:\\Users\\Koushik\\Downloads\\Bhajansdbout.csv"

# Process the CSV file
process_csv(input_file, output_file)
