<?php
/**
 * Марки для страниц /kovriki/{марка}/ — «Коврики для Mercedes-Benz» (ЭВА + ворс на одной странице).
 * slug => [Название, 'для кого' (для заголовков), [популярные модели], файл логотипа в uploads/2024/02/ или ''].
 * Добавить марку: новая строка. Страница и карта сайта обновятся автоматически.
 */
defined('ABSPATH') || exit;

return [
	'volkswagen'    => ['Volkswagen', 'Фольксваген', ['Passat', 'Golf', 'Polo', 'Tiguan', 'Touareg', 'Jetta', 'Touran', 'Sharan', 'Caddy', 'Transporter', 'ID.4', 'ID.6'], 'Volkswagen-logo.jpg'],
	'renault'       => ['Renault', 'Рено', ['Logan', 'Sandero', 'Duster', 'Arkana', 'Kaptur', 'Megane', 'Laguna', 'Scenic', 'Koleos', 'Fluence'], 'Renault.jpg'],
	'toyota'        => ['Toyota', 'Тойота', ['Camry', 'Corolla', 'RAV4', 'Land Cruiser', 'Land Cruiser Prado', 'Highlander', 'Avensis', 'Auris', 'C-HR', 'Yaris'], 'toyota.jpg'],
	'geely'         => ['Geely', 'Джили', ['Coolray', 'Atlas', 'Atlas Pro', 'Monjaro', 'Tugella', 'Emgrand', 'Okavango', 'Preface', 'Geometry C'], 'geely.jpg'],
	'audi'          => ['Audi', 'Ауди', ['A4', 'A6', 'A8', 'A3', 'A5', 'A7', 'Q3', 'Q5', 'Q7', 'Q8', 'e-tron'], 'audi.jpg'],
	'bmw'           => ['BMW', 'БМВ', ['3 серии', '5 серии', '7 серии', 'X1', 'X3', 'X5', 'X6', 'X7', 'iX', 'i4'], 'cropped-bmw.webp'],
	'mercedes-benz' => ['Mercedes-Benz', 'Мерседес', ['C-Class', 'E-Class', 'S-Class', 'GLC', 'GLE', 'GLS', 'G-Class', 'A-Class', 'CLA', 'Vito', 'Sprinter'], 'cropped-mercedes-benz.jpg'],
	'opel'          => ['Opel', 'Опель', ['Astra', 'Vectra', 'Insignia', 'Zafira', 'Corsa', 'Meriva', 'Mokka', 'Antara', 'Omega'], 'opel.jpg'],
	'ford'          => ['Ford', 'Форд', ['Focus', 'Mondeo', 'Kuga', 'Fiesta', 'Galaxy', 'S-Max', 'Explorer', 'Transit', 'Escape'], 'ford.jpg'],
	'hyundai'       => ['Hyundai', 'Хендай', ['Tucson', 'Santa Fe', 'Solaris', 'Accent', 'Elantra', 'Sonata', 'Creta', 'i30', 'ix35', 'Palisade'], ''],
	'kia'           => ['Kia', 'Киа', ['Sportage', 'Rio', 'Ceed', 'Sorento', 'Optima', 'K5', 'Seltos', 'Soul', 'Carnival'], ''],
	'skoda'         => ['Skoda', 'Шкода', ['Octavia', 'Superb', 'Kodiaq', 'Karoq', 'Rapid', 'Fabia', 'Yeti', 'Kamiq'], ''],
	'nissan'        => ['Nissan', 'Ниссан', ['Qashqai', 'X-Trail', 'Almera', 'Juke', 'Note', 'Murano', 'Pathfinder', 'Teana', 'Leaf'], ''],
	'mazda'         => ['Mazda', 'Мазда', ['Mazda 3', 'Mazda 6', 'CX-5', 'CX-30', 'CX-7', 'CX-9', 'Mazda 5'], ''],
	'mitsubishi'    => ['Mitsubishi', 'Митсубиси', ['Outlander', 'ASX', 'Lancer', 'Pajero', 'Pajero Sport', 'L200', 'Eclipse Cross'], ''],
	'peugeot'       => ['Peugeot', 'Пежо', ['308', '3008', '508', '5008', '408', '2008', 'Partner', 'Expert'], 'peugeot.jpg'],
	'citroen'       => ['Citroen', 'Ситроен', ['C4', 'C5', 'C4 Picasso', 'Berlingo', 'C3', 'C5 Aircross', 'Jumpy'], ''],
	'honda'         => ['Honda', 'Хонда', ['Civic', 'Accord', 'CR-V', 'HR-V', 'Pilot', 'Jazz'], 'honda.jpg'],
	'chevrolet'     => ['Chevrolet', 'Шевроле', ['Cruze', 'Aveo', 'Lacetti', 'Captiva', 'Malibu', 'Tahoe', 'Equinox', 'Volt'], 'Chevrolet.jpg'],
	'lada'          => ['Lada', 'Лада', ['Vesta', 'Granta', 'XRAY', 'Niva', 'Niva Travel', 'Largus', 'Priora', 'Kalina'], ''],
	'belgee'        => ['Belgee', 'Белджи', ['X50', 'X70', 'S50'], ''],
	'haval'         => ['Haval', 'Хавал', ['Jolion', 'F7', 'F7x', 'H6', 'Dargo', 'H9', 'M6'], ''],
	'chery'         => ['Chery', 'Чери', ['Tiggo 4', 'Tiggo 7 Pro', 'Tiggo 8', 'Tiggo 8 Pro', 'Arrizo 8'], ''],
	'byd'           => ['BYD', 'БИД', ['Song Plus', 'Han', 'Tang', 'Seal', 'Atto 3', 'Qin Plus', 'Yuan Plus'], 'byd.jpg'],
	'zeekr'         => ['Zeekr', 'Зикр', ['001', '007', '009', 'X', '7X'], 'zeekr.jpg'],
	'lixiang'       => ['LiXiang', 'Лисян', ['L6', 'L7', 'L8', 'L9', 'One'], ''],
	'tesla'         => ['Tesla', 'Тесла', ['Model 3', 'Model Y', 'Model S', 'Model X'], ''],
	'lexus'         => ['Lexus', 'Лексус', ['RX', 'NX', 'ES', 'LX', 'GX', 'IS', 'UX'], ''],
	'volvo'         => ['Volvo', 'Вольво', ['XC60', 'XC90', 'XC40', 'S60', 'S80', 'V60', 'V70'], ''],
	'land-rover'    => ['Land Rover', 'Ленд Ровер', ['Range Rover', 'Range Rover Sport', 'Evoque', 'Velar', 'Discovery', 'Discovery Sport', 'Defender'], ''],
	'subaru'        => ['Subaru', 'Субару', ['Forester', 'Outback', 'XV', 'Impreza', 'Legacy'], ''],
	'porsche'       => ['Porsche', 'Порше', ['Cayenne', 'Macan', 'Panamera', 'Taycan'], ''],
	'acura'         => ['Acura', 'Акура', ['MDX', 'RDX', 'TLX', 'ZDX'], 'acura.jpg'],
	'chrysler'      => ['Chrysler', 'Крайслер', ['Pacifica', '300C', 'Voyager', 'Town & Country'], 'chrysler.jpg'],
	'buick'         => ['Buick', 'Бьюик', ['Envision', 'Encore', 'Enclave', 'Regal'], 'buick.jpg'],
	'maserati'      => ['Maserati', 'Мазерати', ['Levante', 'Ghibli', 'Quattroporte', 'Grecale'], 'cropped-maserati-1.jpg'],
];
