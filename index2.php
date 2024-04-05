<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quiz sur la Culture Populaire</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <h1>Quiz Velu de Lours</h1>
    <div id="theme-difficulty">
      <p id="theme"></p>
      <p id="difficulty"><div id="difficultyPoint"></div></p>
    </div>
    <div id="question-container"></div>
    <button id="next-btn">Suivant</button>
    <button id="show-answer-btn">Réponse</button>
    <button id="square-btn">Carré</button>
    <div id="answer-container"></div>
</div>
<div class="array">
    <!-- Nouveau contenu -->
    <div id="participants">
        <input type="text" id="participant-name" placeholder="Nom du participant">
        <button id="add-participant-btn">Ajouter</button>
    </div>
    <table id="score-table">
      <thead>
        <tr>
          <th>Joueurs</th>
          <th>Points</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <!-- rempli -->
      </tbody>
    </table>
</div>  
  <script src="script.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
        const questionContainer = document.getElementById('question-container');
        const answerContainer = document.getElementById('answer-container');
        const nextButton = document.getElementById('next-btn');
        const showAnswerButton = document.getElementById('show-answer-btn');
        const squareButton = document.getElementById('square-btn');
        const addParticipantButton = document.getElementById('add-participant-btn');
        const participantNameInput = document.getElementById('participant-name');
        const themeElement = document.getElementById('theme');
        const difficultyElement = document.getElementById('difficulty');
        let answer = '';
        let options = [];
        let buttons = []; // bouton tableau score

        function fetchQuestion() {
            const xhr = new XMLHttpRequest();
            
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        const data = JSON.parse(xhr.responseText);
                        if (data.length > 0) {
                            const questionData = data[0];
                            const question = questionData.question;
                            answer = questionData.bonne_reponse;
                            const mauvaiseReponse1 = questionData.mauvaise_reponse1;
                            const mauvaiseReponse2 = questionData.mauvaise_reponse2;
                            const mauvaiseReponse3 = questionData.mauvaise_reponse3;
                            const theme = questionData.theme;
                            const difficulty = questionData.difficulty;

                            questionContainer.innerHTML = question;
                            options = [answer, mauvaiseReponse1, mauvaiseReponse2, mauvaiseReponse3];
                            themeElement.textContent = `Thème: ${theme}`;
                            difficultyElement.textContent = `Difficulté: ${difficulty}`;
                        } else {
                            console.log("Aucune question trouvée");
                        }
                    } else {
                        console.error("Une erreur est survenue lors de la récupération des questions:", xhr.status);
                    }
                }
            };
            
            xhr.open('GET', 'question.php', true);
            xhr.send();
        }

        fetchQuestion(); // Appeler fetchQuestion au chargement de la page

        nextButton.addEventListener('click', fetchQuestion);

        squareButton.addEventListener('click', () => {
            displayButtons();
        });

        showAnswerButton.addEventListener('click', () => {
            answerContainer.innerHTML = `${answer}`;
        });

        addParticipantButton.addEventListener('click', () => {
            const participantName = participantNameInput.value.trim();
            if (participantName) {
                addParticipant(participantName);
                participantNameInput.value = '';
            }
        });

        function addParticipant(name) {
            const tableBody = document.querySelector('#score-table tbody');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${name}</td>
                <td>0</td>
                <td>
                    <button class="add-point-btn">+</button>
                    <button class="subtract-point-btn">-</button>
                </td>
            `;
            tableBody.appendChild(row);

            const addPointButton = row.querySelector('.add-point-btn');
            const subtractPointButton = row.querySelector('.subtract-point-btn');

            addPointButton.addEventListener('click', () => {
                addPoint(row);
            });

            subtractPointButton.addEventListener('click', () => {
                subtractPoint(row);
            });
        }

        function addPoint(row) {
            const pointsCell = row.querySelector('td:nth-child(2)');
            let points = parseInt(pointsCell.textContent);
            points++;
            pointsCell.textContent = points;
        }

        function subtractPoint(row) {
            const pointsCell = row.querySelector('td:nth-child(2)');
            let points = parseInt(pointsCell.textContent);
            //decomenter le if pour empecher les scores negatifs
            //if (points > 0) 
            {
                points--;
                pointsCell.textContent = points;
            }
        }
    });
  </script>
</body>
</html>
