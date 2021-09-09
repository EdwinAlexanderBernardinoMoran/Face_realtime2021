import cv2 
import os
import imutils
import numpy as np
# from tkinter import *
# from tkinter import messagebox as msg

#Colores Login
# txt_login = "Iniciar Sesión"
# txt_register = "Registrarse"

# color_white = "#f4f5f4"
# color_aqua = "#50E3C2"
# color_black = "#101010"
# color_black_btn = "#202020"
# color_background = "#071A33"
# font_label = "Century Gothic"
# font_label1= "cursive"
# size_screen = "500x300"

# # #Funciones
# def getEnter(screen):
#     ''' Establece un espaciado en la pantalla(un salto de linea) '''
#     Label(screen, text="", bg=color_background).pack()

# def login_register():
#     '''Muestra la pantalla de inicio de sesion'''
#     global pantalla1
#     pantalla1=Toplevel(pantalla)
#     pantalla1.configure(bg=color_background)
#     pantalla1.geometry(size_screen)
#     pantalla1.title("Registrate")
#     Label(pantalla1,text="Bienvenido a Face-Realtime", fg=color_aqua, bg=color_black, font=(font_label, 18), width="500", height="2").pack()
#     image = PhotoImage(file="./ico/logo.gif")
#     image =image.subsample(2,2)
#     Label(pantalla1, image=image, border=3).pack()
#     getEnter(pantalla1)
#     global verificarUsuario

#     verificarUsuario=StringVar()
#     Label(pantalla1, text="Introduce tu nombre: ", fg=color_white, bg=color_black, font=(font_label1, 18), width="500", height="2").pack()
#     Entry(pantalla1, textvariable=verificarUsuario, justify=CENTER, font=(font_label, 12)).pack()
  
#     Button(text=txt_register, fg=color_white, bg=color_black_btn, activebackground=color_background, borderwidth=0, font=(font_label, 14), height="2", width="40").pack()

#     pantalla1.mainloop()

   

# #Interfaz de Usuario
# pantalla = Tk()
# pantalla.geometry(size_screen)
# pantalla.title("Face-Realtime")
# pantalla.configure(bg=color_background)
# pantalla.iconbitmap('./ico/logo.ico')
# Label(text="¡Bienvenido(a) al sistema!", fg=color_aqua, bg=color_black, font=(font_label, 18), width="500", height="2").pack()

# getEnter(pantalla)
# Button(text=txt_login, fg=color_white, bg=color_background, activebackground=color_background, borderwidth=0, font=(font_label, 14), height="2", width="40", command=txt_login, border="2"
# ).pack()

# getEnter(pantalla)
# Button(text=txt_register, fg=color_white, bg=color_black_btn, activebackground=color_background, borderwidth=0, font=(font_label, 14), height="2", width="40", command=login_register).pack()

# pantalla.mainloop()

#Capturando rostros
dataPath = 'C:/Users/MINEDUCYT/Desktop/ReconocimientoFacial/Data'
personName = input("Digita tu nombre: ")
personPath = dataPath + '/' + personName

if not os.path.exists(personPath):
    # print('Carpeta creada: ',personPath)
    print("Carpeta Creada: ", personPath)
    os.makedirs(personPath)

cap = cv2.VideoCapture(0,cv2.CAP_DSHOW)

faceClassif = cv2.CascadeClassifier(cv2.data.haarcascades+'haarcascade_frontalface_default.xml')
count = 0

while True:

    ret, frame = cap.read()
    if ret == False: break
    frame =  imutils.resize(frame, width=640)
    gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
    auxFrame = frame.copy()

    faces = faceClassif.detectMultiScale(gray,1.3,5)

for (x,y,w,h) in faces:
    cv2.rectangle(frame, (x,y),(x+w,y+h),(0,255,0),2)
    rostro = auxFrame[y:y+h,x:x+w]
    rostro = cv2.resize(rostro,(150,150),interpolation=cv2.INTER_CUBIC)
    cv2.imwrite(personPath + '/rotro_{}.jpg'.format(count),rostro)
    count = count + 1
    cv2.imshow('frame',frame)

    k =  cv2.waitKey(1)
    if k == 27 or count >= 300:
        break

cap.release()
cv2.destroyAllWindows()



#Capturando rostros
# Entrenamiento

# dataPath = 'C:/Users/MINEDUCYT/Desktop/ReconocimientoFacial/Data' #Cambia a la ruta donde hayas almacenado Data
# peopleList = os.listdir(dataPath)
# print('Lista de personas: ', peopleList)

# labels = []
# facesData = []
# label  = 0

# for nameDir in peopleList:
#     personPath = dataPath + '/' + nameDir
#     print("Leyendo Imagenes... ")

#     for fileName in os.listdir(personPath):
#         print('Rostros: ', nameDir + '/' + fileName)
#         labels.append(label)
#         facesData.append(cv2.imread(personPath + '/' + fileName, 0))
#         image = cv2.imread(personPath + '/' + fileName, 0)
#         # cv2.imshow('image', image)
#         # cv2.waitKey(10)
#     label = label+1

# # print('labels: ',labels)
# # print("numero de etiquetas 0: ", np.count_nonzero(np.array(labels)== 0))
# # print("numero de etiquetas 1: ", np.count_nonzero(np.array(labels)== 1))


# face_recognizer = cv2.face.LBPHFaceRecognizer_create()

# print("Entrenando... ")
# face_recognizer.train(facesData, np.array(labels))
# face_recognizer.write('modeloLBPHFace.xml')
# print("Modelo almacenado... Listo!!!")

