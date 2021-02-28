let images = document.querySelectorAll('#mosaique img')
let selected = document.getElementById('selected-image')

for(image of images){

    image.addEventListener('mouseenter', function(){
        selected.src = this.src
    })
}