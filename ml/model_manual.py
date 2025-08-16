# model_manual.py
def prediksi_label(tryout, evaluasi, tugas):
    if tryout >= 65:
        if evaluasi >= 65:
            return 'Lulus'
        else:
            return 'Beresiko'
    else:
        if tugas >= 65:
            return 'Beresiko'
        else:
            return 'Tidak Lulus'

class ManualDecisionTree:
    def predict(self, X):
        return [prediksi_label(row['tryout'], row['evaluasi'], row['tugas']) for _, row in X.iterrows()]
