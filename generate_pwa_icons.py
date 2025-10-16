#!/usr/bin/env python3
"""
Script para generar iconos PWA de diferentes tamaños
Requiere PIL (Pillow): pip install Pillow
"""

from PIL import Image, ImageDraw
import os

def create_simple_icon(size, output_path):
    """Crear un icono simple con el texto 'BR' (Bienes Raíces)"""
    # Crear una imagen cuadrada
    img = Image.new('RGB', (size, size), color='#1976d2')
    draw = ImageDraw.Draw(img)
    
    # Calcular el tamaño de la fuente basado en el tamaño del icono
    font_size = size // 3
    
    # Dibujar el texto "BR" en el centro
    text = "BR"
    # Obtener el tamaño del texto
    bbox = draw.textbbox((0, 0), text, font=None)
    text_width = bbox[2] - bbox[0]
    text_height = bbox[3] - bbox[1]
    
    # Calcular la posición centrada
    x = (size - text_width) // 2
    y = (size - text_height) // 2
    
    # Dibujar el texto en blanco
    draw.text((x, y), text, fill='white')
    
    # Guardar la imagen
    img.save(output_path, 'PNG')
    print(f"Icono creado: {output_path}")

def generate_pwa_icons():
    """Generar todos los iconos PWA necesarios"""
    # Tamaños necesarios para PWA
    sizes = [72, 96, 128, 144, 152, 192, 384, 512]
    
    # Directorio base para los iconos
    base_dir = "public/img"
    
    # Crear directorio si no existe
    os.makedirs(base_dir, exist_ok=True)
    
    for size in sizes:
        output_path = f"{base_dir}/icon-{size}x{size}.png"
        create_simple_icon(size, output_path)
    
    print("\n✅ Todos los iconos PWA han sido generados exitosamente!")
    print("📱 Los iconos están listos para usar en tu PWA")
    print("\n💡 Consejo: Puedes reemplazar estos iconos básicos con el logo de tu empresa")

if __name__ == "__main__":
    generate_pwa_icons()