<?php

//Table Options -> don't modify
maketable($tableoptions);
makecolumn("optionname", $tableoptions, "VARCHAR (300) NOT NULL");
makecolumn("optionvalue", $tableoptions, "VARCHAR (2000) NOT NULL");
//--> don't modify


//Table Users
maketable($tableusers);
makecolumn("nickname", $tableusers, "VARCHAR(300) NOT NULL");
makecolumn("timestamp", $tableusers, "VARCHAR(300) NOT NULL");
makecolumn("email", $tableusers, "VARCHAR(300) NOT NULL");
makecolumn("password", $tableusers, "VARCHAR(300) NOT NULL");
makecolumn("uniqid", $tableusers, "VARCHAR(300) NOT NULL");
makecolumn("confirmed", $tableusers, "INT(6) NOT NULL");
makecolumn("resetcode", $tableusers, "VARCHAR(300) NOT NULL");


//Table payments and purchases
maketable($tablepurchases);
makecolumn("paid", $tablepurchases, "INT(6) NOT NULL");
makecolumn("userid", $tablepurchases, "INT(6) NOT NULL");
makecolumn("paymentid", $tablepurchases, "VARCHAR(300) NOT NULL");
makecolumn("purchaseinfo", $tablepurchases, "VARCHAR(300) NOT NULL");
makecolumn("bookid", $tablepurchases, "VARCHAR(300) NOT NULL");
makecolumn("timestamp", $tablepurchases, "VARCHAR(300) NOT NULL");
makecolumn("price", $tablepurchases, "INT(6) NOT NULL");


//Table books
maketable($tablebooks);
makecolumn("title", $tablebooks, "VARCHAR(300) NOT NULL");
makecolumn("author", $tablebooks, "VARCHAR(300) NOT NULL");
makecolumn("pdf", $tablebooks, "VARCHAR(300) NOT NULL");
makecolumn("cover", $tablebooks, "VARCHAR(300) NOT NULL");
makecolumn("catid", $tablebooks, "INT(6) NOT NULL");
makecolumn("price", $tablebooks, "INT(6) NOT NULL");
makecolumn("status", $tablebooks, "INT(6) NOT NULL");
makecolumn("description", $tablebooks, "VARCHAR(5000) NOT NULL");


//Table categories
maketable($tablecategories);
makecolumn("title", $tablecategories, "VARCHAR(300) NOT NULL");


//Table sliders
maketable($tablesliders);
makecolumn("image", $tablesliders, "VARCHAR(300) NOT NULL");
makecolumn("link", $tablesliders, "VARCHAR(300) NOT NULL");

//Table payments
maketable($tablepayments);
makecolumn("userid", $tablepayments, "INT(6) NOT NULL");
makecolumn("status", $tablepayments, "INT(6) NOT NULL");
makecolumn("total", $tablepayments, "INT(6) NOT NULL");
makecolumn("paymentid", $tablepayments, "VARCHAR(300) NOT NULL");
makecolumn("timestamp", $tablepayments, "VARCHAR(300) NOT NULL");