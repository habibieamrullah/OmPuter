<style>

@import url('https://fonts.googleapis.com/css2?family=Quicksand&display=swap');

/* SCROLLBAR STYLING */
/* width */
::-webkit-scrollbar {
	width: 0.25em;
	height: 3px;
}
/* Track */
::-webkit-scrollbar-track {
	background: #ebebeb; 
	border-radius: 00px;
}
/* Handle */
::-webkit-scrollbar-thumb {
	background: black;
	border-radius: 0px;
}
/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
	background: gray; 
}

body{
	font-family: 'Quicksand', sans-serif;
	padding: 0px;
	margin: 0px;
	overflow-x: hidden;
}

h1, h2, h3, h4, h5, p{
	padding: 0px;
	margin: 0px;
	margin-bottom: 0.25em;
}

.maxwidtha{
	max-width: 720px;
	margin: 0 auto;
	padding: 14px;
}

.maxwidthb{
	max-width: 1080px;
	margin: 0 auto;
	padding: 14px;
}

.maxwidthc{
	max-width: 512px;
	margin: 0 auto;
	padding: 14px;
}

.topcolorart{
	background-color: <?php echo getoption("primarycolor") ?>;
	width: 100%;
	height: 3px;
	margin-bottom: 1em;
	
}

.tcell{
	display: table-cell;
	vertical-align: top;
}

a{
	text-decoration: none;
	color: <?php echo getoption("linkcolor") ?>;
	
}

a:hover{
	text-decoration: none;
}

.categorymenuitem{
	font-weight: bold;
	display: inline-block;
	cursor: pointer;
	padding: 10px;
	transition: color, background-color 600ms;
}

.categorymenuitem:hover{
	background-color: <?php echo getoption("primarycolor") ?>;
	color: white;
}

.homebookthumb{
	display: inline-block;
	width: 192px;
	vertical-align: top;
	margin: 10px;
}

.addtocartbutton{
	border: none;
	outline: none;
	background-color: <?php echo getoption("primarycolor") ?>;
	color: white;
	border: 1px solid <?php echo getoption("primarycolor") ?>;
	transition: color, background-color 600ms;
	cursor: pointer;
	padding: 10px;
	margin-top: 20px;
}


.addtocartbutton:hover{
	color: <?php echo getoption("primarycolor") ?>;
	background-color: white;
	
}

.viewcartbutton{
	border: none;
	outline: none;
	background-color: <?php echo getoption("secondarycolor") ?>;
	color: white;
	border: 1px solid <?php echo getoption("secondarycolor") ?>;
	transition: color, background-color 600ms;
	cursor: pointer;
	padding: 10px;
	margin-top: 20px;
}


.viewcartbutton:hover{
	color: <?php echo getoption("secondarycolor") ?>;
	background-color: white;
}

input{
	background-color: #ebebeb; color: gray; width: 100%; padding: 10px; box-sizing: border-box; border: none; outline: none;
}



.submitbutton{
	background-color: <?php echo getoption("primarycolor") ?>;
	color: white;
	border: 1px solid <?php echo getoption("primarycolor") ?>;
	transition: color, background-color 600ms;
	cursor: pointer;
	margin-top: 10px;
	margin-bottom: 10px;
}

.submitbutton:hover{
	color: <?php echo getoption("primarycolor") ?>;
	background-color: white;
	
}

.leftmenuitem{
	border-bottom: 1px solid gray;
	padding: 5px;
}

table{
	border-collapse: collapse;
}
tr, th, td{
	border: 1px solid black;
	padding: 0.5em;
}

.hideondesktop{
	display: none;
}

/* mobile view */
@media (max-width: 920px){
	.hideondesktop{
		display: block;
	}
	.hideonmobile{
		display: none;
	}
	.homebookthumb{
		width: 40%;
	}
	.categorymenuitem{
		display: block;
		width: 100%;
		box-sizing: border-box;
	}
}

</style>