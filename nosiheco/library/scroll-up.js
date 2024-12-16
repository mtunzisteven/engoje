

window.addEventListener('scroll', function() {
    var scrollPosition = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
    if (scrollPosition > 350) {
      document.getElementById('scrollUp').style.display = 'block';
    } else {
      document.getElementById('scrollUp').style.display = 'none';
    }
  });
  
  document.getElementById('scrollUp').addEventListener('click', function() {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
  