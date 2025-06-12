import pandas as pd
import joblib
from sklearn.tree import DecisionTreeClassifier
from sklearn.model_selection import train_test_split
from sklearn.metrics import accuracy_score

# Load data
data = pd.read_csv("ml/data-siswa.csv")

# Hitung skor akhir dengan bobot
data['skor_akhir'] = (
    data['tryout'] * 0.4 +
    data['evaluasi'] * 0.3 +
    data['tugas'] * 0.3
)

# Buat label berdasarkan aturan
def labelkan(skor):
    if skor < 60:
        return 'Tidak Lulus'
    elif skor <= 65:
        return 'Beresiko'
    else:
        return 'Lulus'

data['label'] = data['skor_akhir'].apply(labelkan)

# Fitur dan label
X = data[['tugas', 'evaluasi', 'tryout']]
y = data['label']

# Train model
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)
model = DecisionTreeClassifier()
model.fit(X_train, y_train)

# Save model
joblib.dump(model, "model_kelulusan.pkl")
print("Model berhasil disimpan!")

# Evaluasi
y_pred = model.predict(X_test)
print("Akurasi:", accuracy_score(y_test, y_pred))
