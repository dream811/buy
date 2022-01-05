$('#carousel-example-generic').carousel(
  {
    interval: 8000
  }
);
$('.s_ss').slick({
  speed: 300,
  slidesToShow: 5,
  slidesToScroll: 1,
  arrows: true, 
  autoplay: true,
  autoplaySpeed: 3000,
  prevArrow : '<button class="slick-prev right-ab-ha" aria-label="Previous" type="button"></button>',
  nextArrow : '<button class="slick-next left-ab-ha" aria-label="Next" type="button"></button>',
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});

function fnMPopClose(PopNm) {
  fnCookieControl( $("#frm" + PopNm + " input[name='closeEvent']:checkbox"), PopNm);
  $("#" + PopNm).hide("slow");
}
function act1(){
  $("#act1").removeClass("btn-ordinary");
  $("#act1").addClass("btn-default");
  $("#act2").removeClass("btn-default");
  $("#act2").addClass("btn-ordinary");
}
function act2(){
  $("#act2").removeClass("btn-ordinary");
  $("#act2").addClass("btn-default");
  $("#act1").removeClass("btn-default");
  $("#act1").addClass("btn-ordinary");
}
$(document).ready(function(){
  $("img.lazy").lazyload();
})

$(".my-rating").starRating({
  readOnly:true,
  starShape: 'rounded',
  starSize: 20,
  emptyColor: 'lightgray',
  hoverColor: 'salmon',
  activeColor: 'crimson',
  minRating: 0
});