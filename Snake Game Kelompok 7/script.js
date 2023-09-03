// Ahmad Alvin Griffin (24060121140106)
// Arya Dheffan Shevchenko (24060121140160)
// Dafa Kurnia Dinata (24060121120003)
// Dhiya Mazaya (24060121140151)
// Rafif Abbrar Maheswara (24060121140163)

const playBoard = document.querySelector(".play-board");
const scoreElement = document.querySelector(".score");
const highScoreElement = document.querySelector(".high-score");
const controls = document.querySelectorAll(".controls i");

let gameOver = false;
let foodX, foodY;
let snakeX = 5, snakeY = 5;
let velocityX = 0, velocityY = 0;
let snakeBody = [];
let setIntervalId;
let score = 0;
let gameStarted = false;

// Mendapat Skor Tertinggi dari Penyimpanan Lokal
let highScore = localStorage.getItem("high-score") || 0;
highScoreElement.innerText = `High Score: ${highScore}`;

const updateFoodPosition = () => {
    // Melewati Value 1 - 30 Secara Acak Sebagai Posisi Makanan
    foodX = Math.floor(Math.random() * 30) + 1;
    foodY = Math.floor(Math.random() * 30) + 1;
}

const handleGameOver = () => {
    clearInterval(setIntervalId);
    const popupContainer = document.getElementById("popupContainer");
    popupContainer.style.display = "flex";
}

const startButton = document.getElementById("startButton");

startButton.addEventListener("click", () => {
  const startPopup = document.getElementById("startPopup");
  startPopup.style.display = "none";
  gameStarted = true;
  // Start the game here (e.g., by calling your initGame function)
});


const changeDirection = e => {
    // Mengubah Arah Gerak Berdasarkan Tombol
    if(e.key === "ArrowUp" && velocityY != 1) {
        velocityX = 0;
        velocityY = -1;
    } else if(e.key === "ArrowDown" && velocityY != -1) {
        velocityX = 0;
        velocityY = 1;
    } else if(e.key === "ArrowLeft" && velocityX != 1) {
        velocityX = -1;
        velocityY = 0;
    } else if(e.key === "ArrowRight" && velocityX != -1) {
        velocityX = 1;
        velocityY = 0;
    }
}

// Memanggil Pengubah Arah pada setiap klik tombol dan meneruskan nilai kumpulan data kunci sebagai objek
controls.forEach(button => button.addEventListener("click", () => changeDirection({ key: button.dataset.key })));

const initGame = () => {
    if (gameOver) return handleGameOver();
    let html = `<div class="food" style="grid-area: ${foodY} / ${foodX}"></div>`;
  
    // Checking if the snake hit the food
    if (snakeX === foodX && snakeY === foodY) {
      updateFoodPosition();
      snakeBody.push([foodY, foodX]); // Pushing food position to snake body array
      score++; // increment score by 1
      highScore = score >= highScore ? score : highScore;
      localStorage.setItem("high-score", highScore);
      scoreElement.innerText = `Score: ${score}`;
      highScoreElement.innerText = `High Score: ${highScore}`;
    }
    // Updating the snake's head position based on the current velocity
    snakeX += velocityX;
    snakeY += velocityY;
  
    // Determine the direction and apply the corresponding CSS class
    let directionClass = "";
    if (velocityX === -1) {
      directionClass = "pacman-left";
    } else if (velocityX === 1) {
      directionClass = "pacman-right";
    } else if (velocityY === -1) {
      directionClass = "pacman-up";
    } else if (velocityY === 1) {
      directionClass = "pacman-down";
    }
  
    // Shifting forward the values of the elements in the snake body by one
    for (let i = snakeBody.length - 1; i > 0; i--) {
      snakeBody[i] = snakeBody[i - 1];
    }
    snakeBody[0] = [snakeX, snakeY]; // Setting first element of snake body to current snake position
  
    // Checking if the snake's head is out of wall, if so setting gameOver to true
    if (snakeX <= 0 || snakeX > 30 || snakeY <= 0 || snakeY > 30) {
      return (gameOver = true);
    }
  
    for (let i = 0; i < snakeBody.length; i++) {
      // Adding a div for each part of the snake's body with the direction class
      html += `<div class="head ${directionClass}" style="grid-area: ${snakeBody[i][1]} / ${snakeBody[i][0]}"></div>`;
      // Checking if the snake head hit the body, if so set gameOver to true
      if (i !== 0 && snakeBody[0][1] === snakeBody[i][1] && snakeBody[0][0] === snakeBody[i][0]) {
        gameOver = true;
      }
    }
    playBoard.innerHTML = html;
};

// Add this at the end of your JavaScript code
window.addEventListener("load", () => {
    const startPopup = document.getElementById("startPopup");
    startPopup.style.display = "flex";
    if (!gameStarted) {
        startPopup.style.display = "flex";
    }
  });


const closePopupButton = document.getElementById("closePopup");

closePopupButton.addEventListener("click", () => {
    const popupContainer = document.getElementById("popupContainer");
    popupContainer.style.display = "none";
    location.reload();
    startPopup.style.display = "none";
});

updateFoodPosition();
setIntervalId = setInterval(initGame, 100);
document.addEventListener("keyup", changeDirection);
