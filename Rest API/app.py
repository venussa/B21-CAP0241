import time, json
import prediction as pred
#import mysql.connector

from flask import Flask, render_template, request, Response
from werkzeug.utils import secure_filename
from werkzeug.datastructures import FileStorage
from datetime import datetime

timestamp = int(time.time()) + (3600 * 7)


#mydb = mysql.connector.connect(host="localhost", user="root", password="gadfrey56", database="bangunan")

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
	# if request.method == 'POST':
	postfile = request.files['file']
	#fullname = str(request.form['fullname'])
	email = str(request.form['email'])
	#geocordinate = str(request.form['geocordinate'])
	#buildtype = str(request.form['buildtype'])
	#address = str(request.form['address'])

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
			'urlimage' : 'http://34.101.207.154/'+path,
			#'buildtype' : buildtype,
			#'address' : address,
			#'geocordinate' : geocordinate,
			'damagelevel' : damagelevel,
			'datetime' : datereport,
			'timestamp' : timestamp,
		}

		#mycursor = mydb.cursor()
		#sql = "INSERT INTO data_process (email, urlimage, buildtype, address, geocordinate, damage_lvl, datetime, timestamp) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)"
		#val = (email, path, buildtype, address, geocordinate, damagelevel, datereport, timestamp)
		#mycursor.execute(sql, val)
		#mydb.commit()

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
	# if request.method == 'POST':
	postfile = request.files['file']
	#fullname = str(request.form['fullname'])
	email = str(request.form['email'])
	#geocordinate = str(request.form['geocordinate'])
	#buildtype = str(request.form['buildtype'])
	#address = str(request.form['address'])

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
			'urlimage' : 'http://34.101.207.154/'+path,
			#'buildtype' : buildtype,
			#'address' : address,
			#'geocordinate' : geocordinate,
			'damagelevel' : damagelevel,
			'datetime' : datereport,
			'timestamp' : timestamp,
		}

		#mycursor = mydb.cursor()

		#sql = "INSERT INTO data_process (email, urlimage, buildtype, address, geocordinate, damage_lvl, datetime, timestamp) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)"
		#val = (email, path, buildtype, address, geocordinate, damagelevel, datereport, timestamp)
		#mycursor.execute(sql, val)

		#mydb.commit()

		return Response(json.dumps(result_set), mimetype='application/json')
	else :
		result_set = {
			'response' : False,
			'message' : 'Illegal Extention',
		}

		return Response(json.dumps(result_set), mimetype='application/json')

if __name__ == '__main__':
   app.run(host = '0.0.0.0' , debug = True)
