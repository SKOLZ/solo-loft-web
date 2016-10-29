//Firefox 2
if (navigator.userAgent.toLowerCase().indexOf('firefox/2') > -1)
document.write('<style type="text/css"> \
a, span, img (display:-moz-inline-box;) \
.opacity (-moz-opacity:0.8) \
</style>');

//Internet Explorer 6
if (navigator.userAgent.toLowerCase().indexOf('ie 6') > -1)
document.write('<style type="text/css"> \
a {color:expression(this.parentNode.currentStyle.color);} \
.lista_jquery li a {width:129px !important} \
.fondo-titulo {opacity: 0.6 !important} \
</style>');

//Internet Explorer 7
if (navigator.userAgent.toLowerCase().indexOf('ie 7') > -1)
document.write('<style type="text/css"> \
a {color:expression(this.parentNode.currentStyle.color);} \
</style>');

//Internet Explorer
if (navigator.userAgent.toLowerCase().indexOf('ie') > -1)
document.write('<style type="text/css"> \
.opacity {filter: alpha(opacity = 80)} \
</style>');

//Safari
if (navigator.userAgent.toLowerCase().indexOf('safari') > -1)
document.write('<style type="text/css"> \
textarea {resize:none;} \
</style>');

//Google Chrome
if (navigator.userAgent.toLowerCase().indexOf('chrome') > -1)
document.write('<style type="text/css"> \
textarea {resize:none;} \
</style>');

//Opera
if (navigator.userAgent.toLowerCase().indexOf('opera') > -1)
document.write('<style type="text/css"> \
</style>');