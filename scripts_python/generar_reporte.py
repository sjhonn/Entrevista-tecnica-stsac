"""Script opcional: genera un resumen rápido de operativos y envíos desde la base de datos SQLite."""
import sqlite3
from pathlib import Path


def generar_reporte():
    ruta_bd = Path(__file__).resolve().parent.parent / 'baseDatos' / 'supply_transport.sqlite'
    conexion = sqlite3.connect(ruta_bd)
    cursor = conexion.cursor()

    cursor.execute('SELECT COUNT(*) FROM operativos')
    total_operativos = cursor.fetchone()[0]

    cursor.execute('SELECT COUNT(*) FROM envios')
    total_envios = cursor.fetchone()[0]

    cursor.execute("SELECT estado, COUNT(*) FROM envios GROUP BY estado")
    por_estado = cursor.fetchall()

    print(f'Operativos registrados: {total_operativos}')
    print(f'Envíos registrados: {total_envios}')
    print('Envíos por estado:')
    for estado, cantidad in por_estado:
        print(f'  - {estado}: {cantidad}')

    conexion.close()


if __name__ == '__main__':
    generar_reporte()
