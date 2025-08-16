from flask import Flask, request, jsonify
import joblib
import pandas as pd
from model_manual import ManualDecisionTree

app = Flask(__name__)

# Load model manual decision tree
model = joblib.load("model_kelulusan.pkl")

def get_persentase_dan_saran(hasil):
    """
    Fungsi untuk menentukan persentase dan saran berdasarkan hasil prediksi.
    """
    if hasil == 'Lulus':
        return 70, 'Pertahankan konsistensi belajar agar hasil tetap optimal.'
    elif hasil == 'Beresiko':
        return 62, 'Tingkatkan konsistensi belajar dan konsultasikan dengan tutor.'
    else: # Jika hasil adalah 'Tidak Lulus' atau lainnya
        return 55, 'Segera evaluasi proses belajar dan minta bantuan mentor.'

@app.route('/prediksi', methods=['POST'])
def prediksi():
    data = request.get_json()
    
    # Ambil input
    tugas = float(data.get('tugas', 0)) # Menggunakan .get() untuk menghindari error jika key tidak ada
    evaluasi = float(data.get('evaluasi', 0))
    tryout = float(data.get('tryout', 0))

    # Handle kasus jika semua nilai 0
    if tugas == 0 and evaluasi == 0 and tryout == 0:
        return jsonify({
            'hasil': 'Belum ada prediksi',
            'persentase': 0,
            'saran': 'Belum ada data nilai yang cukup untuk melakukan prediksi.'
        })

    # Buat DataFrame 1 baris untuk prediksi
    df = pd.DataFrame([{
        'tugas': tugas,
        'evaluasi': evaluasi,
        'tryout': tryout
    }])
    
    # Prediksi menggunakan model
    hasil = model.predict(df)[0]
    
    # Dapatkan persentase dan saran berdasarkan hasil prediksi
    persentase, saran = get_persentase_dan_saran(hasil)

    # Kembalikan semua data yang dibutuhkan Laravel
    return jsonify({
        'hasil': hasil,
        'persentase': persentase,
        'saran': saran
    })

if __name__ == '__main__':
    app.run(port=5001)