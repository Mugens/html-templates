
  const btnVideo = document.querySelector('.btn-video');
  const video = document.querySelector('.banner_iframe');
  const btnsBanner = document.querySelector('.banner_btns');

  if(btnVideo){
    btnVideo.addEventListener('click',function(e){
      e.preventDefault();
      video.src = video.dataset.src;
      btnsBanner.classList.add('z-zero');
      btnVideo.classList.add('d-none');
    })
  }


  var menuBtn = document.querySelector(".menu-btn");
  const menu = document.querySelector(".menu-colapse");

  menuBtn.addEventListener("click", function() {
    menuBtn.classList.toggle("is--active");
    menu.classList.toggle("d-block");
  });


