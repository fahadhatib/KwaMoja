<?php
InsertRecord('accountsection',array('sectionid'),array(10),array('sectionid','sectionname'),array(10,'Assets'));
InsertRecord('accountsection',array('sectionid'),array(20),array('sectionid','sectionname'),array(20,'Liabilities'));
InsertRecord('accountsection',array('sectionid'),array(30),array('sectionid','sectionname'),array(30,'Income'));
InsertRecord('accountsection',array('sectionid'),array(40),array('sectionid','sectionname'),array(40,'Costs'));
InsertRecord('accountgroups',array('groupname'),array('CAPITAL ASSETS'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('CAPITAL ASSETS','10','0','3000',''));
InsertRecord('accountgroups',array('groupname'),array('COST OF GOODS SOLD'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('COST OF GOODS SOLD','40','1','10000',''));
InsertRecord('accountgroups',array('groupname'),array('CURRENT ASSETS'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('CURRENT ASSETS','10','0','1000',''));
InsertRecord('accountgroups',array('groupname'),array('CURRENT LIABILITIES'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('CURRENT LIABILITIES','20','0','4000',''));
InsertRecord('accountgroups',array('groupname'),array('GENERAL & ADMINISTRATIVE EXPEN'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('GENERAL & ADMINISTRATIVE EXPEN','40','1','12000',''));
InsertRecord('accountgroups',array('groupname'),array('INVENTORY ASSETS'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('INVENTORY ASSETS','10','0','2000',''));
InsertRecord('accountgroups',array('groupname'),array('LONG TERM LIABILITIES'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('LONG TERM LIABILITIES','20','0','6000',''));
InsertRecord('accountgroups',array('groupname'),array('OTHER REVENUE'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('OTHER REVENUE','30','1','9000',''));
InsertRecord('accountgroups',array('groupname'),array('PAYROLL DEDUCTIONS'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('PAYROLL DEDUCTIONS','20','0','5000',''));
InsertRecord('accountgroups',array('groupname'),array('PAYROLL EXPENSES'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('PAYROLL EXPENSES','40','1','11000',''));
InsertRecord('accountgroups',array('groupname'),array('SALES REVENUE'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('SALES REVENUE','30','1','8000',''));
InsertRecord('accountgroups',array('groupname'),array('SHARE CAPITAL'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('SHARE CAPITAL','20','0','7000',''));
InsertRecord('chartmaster',array('accountcaode'),array('1060'),array('accountcode','accountname','group_'),array('1060','Chequing Account','CURRENT ASSETS'));
InsertRecord('chartmaster',array('accountcaode'),array('1065'),array('accountcode','accountname','group_'),array('1065','Petty Cash','CURRENT ASSETS'));
InsertRecord('chartmaster',array('accountcaode'),array('1200'),array('accountcode','accountname','group_'),array('1200','Accounts Receivables','CURRENT ASSETS'));
InsertRecord('chartmaster',array('accountcaode'),array('1205'),array('accountcode','accountname','group_'),array('1205','Allowance for doubtful accounts','CURRENT ASSETS'));
InsertRecord('chartmaster',array('accountcaode'),array('1520'),array('accountcode','accountname','group_'),array('1520','Inventory / General','INVENTORY ASSETS'));
InsertRecord('chartmaster',array('accountcaode'),array('1530'),array('accountcode','accountname','group_'),array('1530','Inventory / Aftermarket Parts','INVENTORY ASSETS'));
InsertRecord('chartmaster',array('accountcaode'),array('1540'),array('accountcode','accountname','group_'),array('1540','Inventory / Raw Materials','INVENTORY ASSETS'));
InsertRecord('chartmaster',array('accountcaode'),array('1820'),array('accountcode','accountname','group_'),array('1820','Office Furniture & Equipment','CAPITAL ASSETS'));
InsertRecord('chartmaster',array('accountcaode'),array('1825'),array('accountcode','accountname','group_'),array('1825','Accum. Amort. -Furn. & Equip.','CAPITAL ASSETS'));
InsertRecord('chartmaster',array('accountcaode'),array('1840'),array('accountcode','accountname','group_'),array('1840','Vehicle','CAPITAL ASSETS'));
InsertRecord('chartmaster',array('accountcaode'),array('1845'),array('accountcode','accountname','group_'),array('1845','Accum. Amort. -Vehicle','CAPITAL ASSETS'));
InsertRecord('chartmaster',array('accountcaode'),array('2100'),array('accountcode','accountname','group_'),array('2100','Accounts Payable','CURRENT LIABILITIES'));
InsertRecord('chartmaster',array('accountcaode'),array('2160'),array('accountcode','accountname','group_'),array('2160','Federal Taxes Payable','CURRENT LIABILITIES'));
InsertRecord('chartmaster',array('accountcaode'),array('2170'),array('accountcode','accountname','group_'),array('2170','Provincial Taxes Payable','CURRENT LIABILITIES'));
InsertRecord('chartmaster',array('accountcaode'),array('2310'),array('accountcode','accountname','group_'),array('2310','GST','CURRENT LIABILITIES'));
InsertRecord('chartmaster',array('accountcaode'),array('2320'),array('accountcode','accountname','group_'),array('2320','PST','CURRENT LIABILITIES'));
InsertRecord('chartmaster',array('accountcaode'),array('2380'),array('accountcode','accountname','group_'),array('2380','Vacation Pay Payable','CURRENT LIABILITIES'));
InsertRecord('chartmaster',array('accountcaode'),array('2390'),array('accountcode','accountname','group_'),array('2390','WCB Payable','CURRENT LIABILITIES'));
InsertRecord('chartmaster',array('accountcaode'),array('2410'),array('accountcode','accountname','group_'),array('2410','EI Payable','PAYROLL DEDUCTIONS'));
InsertRecord('chartmaster',array('accountcaode'),array('2420'),array('accountcode','accountname','group_'),array('2420','CPP Payable','PAYROLL DEDUCTIONS'));
InsertRecord('chartmaster',array('accountcaode'),array('2450'),array('accountcode','accountname','group_'),array('2450','Income Tax Payable','PAYROLL DEDUCTIONS'));
InsertRecord('chartmaster',array('accountcaode'),array('2620'),array('accountcode','accountname','group_'),array('2620','Bank Loans','LONG TERM LIABILITIES'));
InsertRecord('chartmaster',array('accountcaode'),array('2680'),array('accountcode','accountname','group_'),array('2680','Loans from Shareholders','LONG TERM LIABILITIES'));
InsertRecord('chartmaster',array('accountcaode'),array('3350'),array('accountcode','accountname','group_'),array('3350','Common Shares','SHARE CAPITAL'));
InsertRecord('chartmaster',array('accountcaode'),array('4020'),array('accountcode','accountname','group_'),array('4020','General Sales','SALES REVENUE'));
InsertRecord('chartmaster',array('accountcaode'),array('4030'),array('accountcode','accountname','group_'),array('4030','Aftermarket Parts','SALES REVENUE'));
InsertRecord('chartmaster',array('accountcaode'),array('4430'),array('accountcode','accountname','group_'),array('4430','Shipping & Handling','OTHER REVENUE'));
InsertRecord('chartmaster',array('accountcaode'),array('4440'),array('accountcode','accountname','group_'),array('4440','Interest','OTHER REVENUE'));
InsertRecord('chartmaster',array('accountcaode'),array('4450'),array('accountcode','accountname','group_'),array('4450','Foreign Exchange Gain / (Loss)','OTHER REVENUE'));
InsertRecord('chartmaster',array('accountcaode'),array('5010'),array('accountcode','accountname','group_'),array('5010','Purchases','COST OF GOODS SOLD'));
InsertRecord('chartmaster',array('accountcaode'),array('5050'),array('accountcode','accountname','group_'),array('5050','Aftermarket Parts','COST OF GOODS SOLD'));
InsertRecord('chartmaster',array('accountcaode'),array('5100'),array('accountcode','accountname','group_'),array('5100','Freight','COST OF GOODS SOLD'));
InsertRecord('chartmaster',array('accountcaode'),array('5410'),array('accountcode','accountname','group_'),array('5410','Wages & Salaries','PAYROLL EXPENSES'));
InsertRecord('chartmaster',array('accountcaode'),array('5420'),array('accountcode','accountname','group_'),array('5420','EI Expense','PAYROLL EXPENSES'));
InsertRecord('chartmaster',array('accountcaode'),array('5430'),array('accountcode','accountname','group_'),array('5430','CPP Expense','PAYROLL EXPENSES'));
InsertRecord('chartmaster',array('accountcaode'),array('5440'),array('accountcode','accountname','group_'),array('5440','WCB Expense','PAYROLL EXPENSES'));
InsertRecord('chartmaster',array('accountcaode'),array('5610'),array('accountcode','accountname','group_'),array('5610','Accounting & Legal','GENERAL & ADMINISTRATIVE EXPEN'));
InsertRecord('chartmaster',array('accountcaode'),array('5615'),array('accountcode','accountname','group_'),array('5615','Advertising & Promotions','GENERAL & ADMINISTRATIVE EXPEN'));
InsertRecord('chartmaster',array('accountcaode'),array('5620'),array('accountcode','accountname','group_'),array('5620','Bad Debts','GENERAL & ADMINISTRATIVE EXPEN'));
InsertRecord('chartmaster',array('accountcaode'),array('5660'),array('accountcode','accountname','group_'),array('5660','Amortization Expense','GENERAL & ADMINISTRATIVE EXPEN'));
InsertRecord('chartmaster',array('accountcaode'),array('5680'),array('accountcode','accountname','group_'),array('5680','Income Taxes','GENERAL & ADMINISTRATIVE EXPEN'));
InsertRecord('chartmaster',array('accountcaode'),array('5685'),array('accountcode','accountname','group_'),array('5685','Insurance','GENERAL & ADMINISTRATIVE EXPEN'));
InsertRecord('chartmaster',array('accountcaode'),array('5690'),array('accountcode','accountname','group_'),array('5690','Interest & Bank Charges','GENERAL & ADMINISTRATIVE EXPEN'));
InsertRecord('chartmaster',array('accountcaode'),array('5700'),array('accountcode','accountname','group_'),array('5700','Office Supplies','GENERAL & ADMINISTRATIVE EXPEN'));
InsertRecord('chartmaster',array('accountcaode'),array('5760'),array('accountcode','accountname','group_'),array('5760','Rent','GENERAL & ADMINISTRATIVE EXPEN'));
InsertRecord('chartmaster',array('accountcaode'),array('5765'),array('accountcode','accountname','group_'),array('5765','Repair & Maintenance','GENERAL & ADMINISTRATIVE EXPEN'));
InsertRecord('chartmaster',array('accountcaode'),array('5780'),array('accountcode','accountname','group_'),array('5780','Telephone','GENERAL & ADMINISTRATIVE EXPEN'));
InsertRecord('chartmaster',array('accountcaode'),array('5785'),array('accountcode','accountname','group_'),array('5785','Travel & Entertainment','GENERAL & ADMINISTRATIVE EXPEN'));
InsertRecord('chartmaster',array('accountcaode'),array('5790'),array('accountcode','accountname','group_'),array('5790','Utilities','GENERAL & ADMINISTRATIVE EXPEN'));
InsertRecord('chartmaster',array('accountcaode'),array('5800'),array('accountcode','accountname','group_'),array('5800','Licenses','GENERAL & ADMINISTRATIVE EXPEN'));
?>