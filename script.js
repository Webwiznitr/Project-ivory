const canvas = document.getElementById('canvas')
const ctx = canvas.getContext('2d')
const name = document.getElementById('name')
const summary = document.getElementById('summary')
const author = document.getElementById('author')
const downloadBtn = document.getElementById('download-btn')

const image = new Image()
image.src = 'template.jpeg'
image.onload = function () {
	drawImage()
}

function drawImage() {
	ctx.drawImage(image, 0, 0, canvas.width, canvas.height)
	ctx.font = '40px monotype'
	ctx.fillStyle = '#000'
	ctx.fillText(name.value, 60, 150,400);
	ctx.fillText(summary.value, 200, 200, 300);
	ctx.fillText(author.value, 120, 350);
}

name.addEventListener('input', function () {
	drawImage()
})
summary.addEventListener('input', function () {
	drawImage()
})
author.addEventListener('input', function () {
	drawImage()
})
downloadBtn.addEventListener('click', function () {
	downloadBtn.href = canvas.toDataURL('image/jpeg')
	downloadBtn.download = 'BlogPost' + name.value
})
