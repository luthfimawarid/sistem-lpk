from flask import Flask, request, jsonify

app = Flask(__name__)

@app.route('/prediksi', methods=['POST'])
def prediksi():
    data = request.get_json()
    tugas = data['tugas']
    evaluasi = data['evaluasi']
    tryout = data['tryout']

    bobot_tugas = data.get('bobot_tugas', 30)
    bobot_evaluasi = data.get('bobot_evaluasi', 30)
    bobot_tryout = data.get('bobot_tryout', 40)

    # Hitung nilai akhir berdasarkan bobot dinamis
    total = (tugas * bobot_tugas + evaluasi * bobot_evaluasi + tryout * bobot_tryout) / 100

    if total > 65:
        hasil = 'Lulus'
    elif total >= 60:
        hasil = 'Beresiko'
    else:
        hasil = 'Tidak Lulus'

    return jsonify({'hasil': hasil, 'skor': total})

if __name__ == '__main__':
    app.run(port=5001)
