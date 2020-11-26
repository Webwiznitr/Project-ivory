const canvas = document.getElementById('canvas')
const ctx = canvas.getContext('2d')
const name = document.getElementById('name')
const summary = document.getElementById('summary')
const author = document.getElementById('author')
const aimage = document.getElementById('aimage')
const preview = document.getElementById('preview')
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
	ctx.fillText(author.value, 190, 350,280);
	ctx.image(preview.value,200,200);
	ctx.image(aimage.value,200,200);
}


aimage.addEventListener('input', function () {
	drawImage()
})

preview.addEventListener('input', function () {
	drawImage()
})

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
	downloadBtn.download = 'BlogPost_' + name.value
})
window.addEventListener('load', function() {
	document.querySelector('input[type="file"]').addEventListener('change', function() {
		if (this.files && this.files[0]) {
			var img = document.querySelector('img');  // $('img')[0]
			img.src = URL.createObjectURL(this.files[0]); // set src to blob url
			img.onload = imageIsLoaded;
		}
	});
  });