import time, json
import prediction as pred
import mysql.connector
import hashlib

from flask import Flask, render_template, request, Response
from werkzeug.utils import secure_filename
from werkzeug.datastructures import FileStorage
from datetime import datetime


mydb = mysql.connector.connect(host="localhost", user="root", password="gadfrey56", database="bangunan")

# extract file name to multi segment
# seg 1 : get original name
# seg 2 : get original extention
def extract_file_name(filename):
	extract = FileStorage(filename)
	splitnm = extract.split('.')
	results = splitnm[len(splitnm)-1]
	return results

# filter allowed extention
# allowed extention ['jpg', 'jpeg', 'png']
def filter_extention(extname):
	allow_ext = ['jpg', 'jpeg', 'png']
	if extname in allow_ext:
		return True
	else:
		return False

# Flask Contructor
app = Flask(__name__)

# scan building
@app.route('/service_scan_building', methods = ['POST'])
def scan_building():
	timestamp = int(time.time()) + (3600 * 7)
	# if request.method == 'POST':
	postfile = request.files['file']
	#fullname = str(request.form['fullname'])
	token = str(request.headers["token"])
	#geocordinate = str(request.form['geocordinate'])
	#buildtype = str(request.form['buildtype'])
	#address = str(request.form['address'])

	mycursor = mydb.cursor(buffered=True)
	sql = "SELECT email FROM data_token WHERE token=%s and start_date < %s and end_date > %s and status = '1'"
	mycursor.execute(sql, (token, timestamp, timestamp))
	row = mycursor.rowcount
	email = mycursor.fetchone()
	email = email[0]

	abs_token = email+'-'+str(timestamp)
	process_token = hashlib.md5(abs_token.encode()).hexdigest()

	if row == False:
		result_set = {
			'response' : False,
			'message' : 'Token Expired.',
		}
		return Response(json.dumps(result_set), mimetype='application/json')
	

	datereport = str(datetime.fromtimestamp(timestamp))

	extention = extract_file_name(postfile.filename)

	check_ext = filter_extention(extention)

	if check_ext == True: 

		set_new_name = []
		set_new_name.append(email.lower().replace(' ','-'))
		set_new_name.append('-'+str(timestamp))
		set_new_name.append('.'+extention)
		set_new_name = ''.join(set_new_name)
		path = 'upload/'+secure_filename(set_new_name)

		postfile.save(path)

		predict = pred.building_prediction(path)

		if predict == 0 :
			damagelevel = 'Tidak Rusak'
		elif predict == 1 :
			damagelevel = 'Rusak Berat'
		else:
			damagelevel = 'Rusak Sedang'

		result_set = {
			'response' : True,
			'message' : 'Image has been predict',
			#'email' : email,
			#'fullname' : fullname,
			'image' : 'http://34.101.207.154/'+path,
			#'buildtype' : buildtype,
			#'address' : address,
			#'geocordinate' : geocordinate,
			'damagelevel' : damagelevel,
			'scantype' : 'Bulding Scan',
			'date_time' : datereport,
			'process_token' : process_token,
		}

		mycursor = mydb.cursor()
		sql = "INSERT INTO data_process (email, scan_type, image, damage_lvl, process_token, timestamp) VALUES (%s, %s, %s, %s, %s, %s)"
		val = (email, 'Building Scan', path, damagelevel, process_token, timestamp)
		mycursor.execute(sql, val)
		mydb.commit()

		return Response(json.dumps(result_set), mimetype='application/json')
	else :
		result_set = {
			'response' : False,
			'message' : 'Illegal Extention',
		}

		return Response(json.dumps(result_set), mimetype='application/json')


# upload service route path
@app.route('/service_scan_road', methods = ['POST'])
def scan_road():
	timestamp = int(time.time()) + (3600 * 7)
	# if request.method == 'POST':
	postfile = request.files['file']
	#fullname = str(request.form['fullname'])
	token = str(request.headers["token"])
	#geocordinate = str(request.form['geocordinate'])
	#buildtype = str(request.form['buildtype'])
	#address = str(request.form['address'])

	mycursor = mydb.cursor(buffered=True)
	sql = "SELECT email FROM data_token WHERE token=%s and start_date < %s and end_date > %s and status = '1'"
	mycursor.execute(sql, (token, timestamp, timestamp))
	row = mycursor.rowcount
	email = mycursor.fetchone()
	email = email[0]

	abs_token = email+'-'+str(timestamp)
	process_token = hashlib.md5(abs_token.encode()).hexdigest()

	if row == False:
		result_set = {
			'response' : False,
			'message' : 'Token Expired.',
		}
		return Response(json.dumps(result_set), mimetype='application/json')

	datereport = str(datetime.fromtimestamp(timestamp))

	extention = extract_file_name(postfile.filename)

	check_ext = filter_extention(extention)

	if check_ext == True: 

		set_new_name = []
		set_new_name.append(email.lower().replace(' ','-'))
		set_new_name.append('-'+str(timestamp))
		set_new_name.append('.'+extention)
		set_new_name = ''.join(set_new_name)
		path = 'upload/'+secure_filename(set_new_name)

		postfile.save(path)

		predict = pred.road_prediction(path)

		if predict == 0 :
			damagelevel = 'Tidak Rusak'
		elif predict == 1 :
			damagelevel = 'Rusak Berat'

		result_set = {
			'response' : True,
			'message' : 'Image has been predict',
			#'email' : email,
			#'fullname' : fullname,
			'image' : 'http://34.101.207.154/'+path,
			#'buildtype' : buildtype,
			#'address' : address,
			#'geocordinate' : geocordinate,
			'damagelevel' : damagelevel,
			'scantype' : 'Road Scan',
			'date_time' : datereport,
			'process_token' : process_token,
		}

		mycursor = mydb.cursor()
		sql = "INSERT INTO data_process (email, scan_type, image, damage_lvl, process_token, timestamp) VALUES (%s, %s, %s, %s, %s, %s)"
		val = (email, 'Road Scan', path, damagelevel, process_token, timestamp)
		mycursor.execute(sql, val)
		mydb.commit()

		return Response(json.dumps(result_set), mimetype='application/json')
	else :
		result_set = {
			'response' : False,
			'message' : 'Illegal Extention',
		}

		return Response(json.dumps(result_set), mimetype='application/json')

if __name__ == '__main__':
   app.run(host = '0.0.0.0' , debug = True)
