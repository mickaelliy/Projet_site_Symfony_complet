// Affichage menu sider de gauche
    function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
    }

    function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
    }

/*
	RequestAnimationFrame Polyfill

	http://paulirish.com/2011/requestanimationframe-for-smart-animating/
	http://my.opera.com/emoller/blog/2011/12/20/requestanimationframe-for-smart-er-animating
	by Erik Möller, fixes from Paul Irish and Tino Zijdel

	MIT license
 */ 
    (function(w,d,undefined){
 
        var el_html = d.documentElement,
            el_body = d.getElementsByTagName('body')[0],
            header = d.getElementById('header'),
            menuIsStuck = function() {
    
    
                var wScrollTop	= w.pageYOffset || el_body.scrollTop,
                    regexp		= /(nav\-is\-stuck)/i,
                    classFound	= el_html.className.match( regexp ),
                    navHeight	= header.offsetHeight,
                    bodyRect	= el_body.getBoundingClientRect(),
                    scrollValue	= 600;
     
                // si le scroll est d'au moins 600 et
                // la class nav-is-stuck n'existe pas sur HTML
                if ( wScrollTop > scrollValue && !classFound ) {
                    el_html.className = el_html.className + ' nav-is-stuck';
                    el_body.style.paddingTop = navHeight + 'px';
                }
     
                // si le scroll est inférieur à 2 et
                // la class nav-is-stuck existe
                if ( wScrollTop < 2 && classFound ) {
                    el_html.className = el_html.className.replace( regexp, '' );
                    el_body.style.paddingTop = '0';
                }
    
            },
            onScrolling = function() {
                // on exécute notre fonction menuIsStuck()
                // dans la fonction onScrolling()
                menuIsStuck();
                // on pourrait faire plein d'autres choses ici 
            };
     
        // quand on scroll
        w.addEventListener('scroll', function(){
            // on exécute la fonction onScrolling()
            w.requestAnimationFrame( onScrolling );
        });
     
    }(window, document));