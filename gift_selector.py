import sys
import json

# Lista de regalos
gifts = [
    "Book", "Toy", "Gadget", "Video Game", "Headphones",
    "Smartphone", "Laptop", "Watch", "Shoes", "Wallet",
    "Headset", "Camera", "Drone", "Smart Watch", "Bluetooth Speaker"
]

# Obtener los índices de los regalos desde los argumentos del script
indices = sys.argv[1:]
try:
    indices = list(map(int, indices))
except ValueError:
    print(json.dumps({"error": "Invalid indices"}))
    sys.exit(1)

# Validar índices y calcular el código único
selected_gifts = []
gift_code = 0

for index in indices:
    if 0 <= index < len(gifts):
        selected_gifts.append(gifts[index])
        gift_code |= (1 << index)

# Crear la respuesta en JSON
response = {
    "selectedGifts": selected_gifts,
    "giftCode": gift_code
}

# Imprimir el resultado en JSON
print(json.dumps(response))
