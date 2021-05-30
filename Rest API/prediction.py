import time
import random as rd
import zipfile, os
from tqdm import tqdm
import numpy as np 
import tensorflow as tf
from tensorflow.keras.optimizers import RMSprop
from tensorflow.keras.preprocessing.image import ImageDataGenerator
from tensorflow.keras import regularizers
from tensorflow.keras.callbacks import LearningRateScheduler, ModelCheckpoint 
from sklearn.preprocessing import LabelEncoder
from tensorflow.keras.preprocessing import image
from tensorflow.keras.utils import to_categorical
import cv2

import matplotlib.image as mpimg
import matplotlib.pyplot as plt
import seaborn as sns


def building_prediction(path):

	model = tf.keras.models.load_model('model/bangunan/model.h5')
	model.load_weights('model/bangunan/model-weight.h5')

	img = image.load_img(path, target_size=(100,100))

	imgplot = plt.imshow(img)
	x = image.img_to_array(img)
	x = np.expand_dims(x, axis=0)

	images = np.vstack([x])
	pred = model.predict(x, batch_size=3)
	classes = np.argmax(pred,axis=1)

	print(classes)
	
	if classes == 0:
	    return 0 # tidak rusak
	elif classes == 1:
	    return 1 # rusak berat
	else:
	    return 2 # rusak sedang

def road_prediction(path):

	model = tf.keras.models.load_model('model/jalanan/model.h5')
	model.load_weights('model/jalanan/model-weight.h5')

	img = image.load_img(path, target_size=(100,100))
	imgplot = plt.imshow(img)
	x = image.img_to_array(img)
	x = np.expand_dims(x, axis=0)

	images = np.vstack([x])
	pred = model.predict(images, batch_size=10)
	classes = np.where(pred>0.5, 1, 0)

	if classes == 0:
	    return 0

	else :
	    return 1
	