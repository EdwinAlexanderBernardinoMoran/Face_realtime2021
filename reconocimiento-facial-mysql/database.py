import mysql.connector as db
import json

with open('keys.json') as json_file:
    keys = json.load(json_file)

def convertToBinaryData(filename):
    # Convert digital data to binary format
    try:
        with open(filename, 'rb') as file:
            binaryData = file.read()
        return binaryData
    except:
        return 0

def write_file(data, path):
    # Convert binary data to proper format and write it on your computer
    with open(path, 'wb') as file:
        file.write(data)

def registerUser(name, photo):
    id = 0
    inserted = 0

    try:
        conexion = db.connect(host='localhost', user='root', password='', database='alumnos')
        cursor = conexion.cursor()
        sql = "INSERT INTO `user`(name, photo) VALUES (%s,%s)"
        pic = convertToBinaryData(photo)

        if pic:
            cursor.execute(sql, (name, pic))
            conexion.commit()
            inserted = cursor.rowcount
            id = cursor.lastrowid
    except db.Error as e:
        print(f"Fallo al insertar la imagen: {e}")
    finally:
        if conexion.is_connected():
            cursor.close()
            conexion.close()
    return {"id": id, "affected":inserted}

def getUser(name, path):
    id = 0
    rows = 0

    try:
        conexion = db.connect(host='localhost', user='root', password='', database='alumnos')
        cursor = conexion.cursor()
        sql = "SELECT * FROM `user` WHERE name = %s"

        cursor.execute(sql, (name,))
        records = cursor.fetchall()

        for row in records:
            id = row[0]
            write_file(row[2], path)
        rows = len(records)
    except db.Error as e:
        print(f"Fallo al leer la imagen: {e}")
    finally:
        if conexion.is_connected():
            cursor.close()
            conexion.close()
    return {"id": id, "affected": rows}
