# prediksi_kelulusan.py

import pandas as pd
import joblib
from sklearn.tree import DecisionTreeClassifier, export_text
from sklearn.metrics import accuracy_score
from sklearn.model_selection import train_test_split

# 1. Load data
data = pd.read_csv("ml/data-siswa.csv")

# Pastikan kolom 'label' sudah ada di CSV
if 'label' not in data.columns:
    raise ValueError("Kolom 'label' harus ada di dataset untuk Decision Tree asli")

# 2. Pisahkan fitur dan target
X = data[['tugas', 'evaluasi', 'tryout']]
y = data['label']

# 3. Split data train & test
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# 4. Buat dan latih model Decision Tree
model = DecisionTreeClassifier(criterion='entropy', max_depth=3, random_state=42)
model.fit(X_train, y_train)

# 5. Prediksi untuk data test
y_pred = model.predict(X_test)

# 6. Evaluasi akurasi
print("Akurasi:", accuracy_score(y_test, y_pred))

# 7. Simpan model
joblib.dump(model, "model_kelulusan.pkl")
print("Model berhasil disimpan!")

# 8. Lihat aturan pohon
rules = export_text(model, feature_names=['tugas', 'evaluasi', 'tryout'])
print("\nStruktur Decision Tree:")
print(rules)
