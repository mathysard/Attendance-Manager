- Gestion de présence

- Liste d'élèves par classe

- "Je donne cours à tel classe à telle heure et je suis tel formateur"

- Formateur associée à une ou plusieurs classes, de même pour élèves

- De 8:20 à 9:10, telle personne était présente, de 9:20 à 10:00 non, etc

- Si toute la classe est présente, bouton "Toute la classe est présente"

- Présence, absence, retard

- Le front-end doit être en React, et le back-end peu importe tant que ça fonctionne

- Savoir expliquer ses choix (analyse de db, choix de techno, ...)

- On doit avoir une option pour faire ses présences pour toute la journée (donc au lieu de faire manuellement 8:20-9:10, 9:10-10:00, ... pouvoir faire de 8:30 à 16:05)

- Historique de présences

- Pouvoir pré-remplir ses présences

- Pouvoir faire ses présences heure par heure ET pouvoir les faire toutes en une fois

- On ne peut remplir que les présences du jour

- Seul les formateurs peuvent accéder à cette plateforme, donc système de login

- Les matières sont pré remplies, et un horaire est lié à une matière

- Analyse db, analyse besoin utilisateur

- Un administrateur doit pouvoir créer des formateurs, et seul un administrateur a ce droit. Si un formateur doit être ajouté à la base de données, il doit passer par l'administrateur.



attendance :
- id
- instructor_id
- hour
- day
- classroom_id
- course_id

administrator :
- id
- first_name
- last_name
- email
- password

instructor :
- id
- first_name
- last_name
- email
- password

course :
- id
- name

classroom :
- id
- name

student :
- id
- first_name
- last_name
- classroom_id

(Jusqu'ici, les tables sont faites. Il ne manque plus que les trois tables de liaisons.)

instructor_classroom :
- id
- instructor_id
- classroom_id

attendance_student :
- id
- attendance_id
- student_id
- student_state