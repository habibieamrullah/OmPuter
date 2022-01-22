function addtocart(bookid){
	location.href = "?cart&add=" + bookid;
}

function search(){
	var q = $("#searchq").val();
	location.href = "?search=" + q;
}

function viewcart(){
	location.href = "?cart";
}

function removefromcart(bookid){
	location.href = "?cart&remove=" + bookid;
}

function checkout(){
	if(innerWidth < innerHeight){
		alert("Mohon login lewat website untuk melanjutkan.");
	}else{
		location.href = "?cart&checkout";
	}
}

function viewpayments(paymentid){
	location.href = "?account&payments=" + paymentid;
}

function readbook(bookid){
	location.href = "?account&readbook=" + bookid;
}

function togglebookcat(){
	$("#bookcat").slideToggle();
}
