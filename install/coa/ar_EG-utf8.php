<?php
InsertRecord('accountsection',array('sectionid'),array(10),array('sectionid','sectionname'),array(10,'Assets'), $db);
InsertRecord('accountsection',array('sectionid'),array(20),array('sectionid','sectionname'),array(20,'Liabilities'), $db);
InsertRecord('accountsection',array('sectionid'),array(30),array('sectionid','sectionname'),array(30,'Income'), $db);
InsertRecord('accountsection',array('sectionid'),array(40),array('sectionid','sectionname'),array(40,'Costs'), $db);
InsertRecord('accountgroups',array('groupname'),array('الاصول الثابتة'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('الاصول الثابتة','10','0','3000',''), $db);
InsertRecord('accountgroups',array('groupname'),array('الاصول المتداولة'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('الاصول المتداولة','10','0','1000',''), $db);
InsertRecord('accountgroups',array('groupname'),array('التزامات قصيرة الاجل'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('التزامات قصيرة الاجل','20','0','4000',''), $db);
InsertRecord('accountgroups',array('groupname'),array('التمات طويلة الاجل'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('التمات طويلة الاجل','20','0','5000',''), $db);
InsertRecord('accountgroups',array('groupname'),array('المخزون كاصل'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('المخزون كاصل','10','0','2000',''), $db);
InsertRecord('accountgroups',array('groupname'),array('ايراد المبيعات'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('ايراد المبيعات','30','1','7000',''), $db);
InsertRecord('accountgroups',array('groupname'),array('ايردات اخرى'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('ايردات اخرى','30','1','9000',''), $db);
InsertRecord('accountgroups',array('groupname'),array('تكلفة البضاعة المباعة'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('تكلفة البضاعة المباعة','40','1','10000',''), $db);
InsertRecord('accountgroups',array('groupname'),array('حقوق الملكية'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('حقوق الملكية','20','0','6000',''), $db);
InsertRecord('accountgroups',array('groupname'),array('راد استشارات'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('راد استشارات','30','1','8000',''), $db);
InsertRecord('accountgroups',array('groupname'),array('مصروفات ادارية و عمومية'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('مصروفات ادارية و عمومية','40','1','12000',''), $db);
InsertRecord('accountgroups',array('groupname'),array('مصروفات الاجور'),array('groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname'),array('مصروفات الاجور','40','1','11000',''), $db);
InsertRecord('chartmaster',array('accountcaode'),array('1060'),array('accountcode','accountname','group_'),array('1060','نقدية بالبنك','الاصول المتداولة'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('1065'),array('accountcode','accountname','group_'),array('1065','نقديةبالصندوق','الاصول المتداولة'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('1200'),array('accountcode','accountname','group_'),array('1200','عملاء','الاصول المتداولة'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('1205'),array('accountcode','accountname','group_'),array('1205','مخصص ديون معدومة','الاصول المتداولة'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('1520'),array('accountcode','accountname','group_'),array('1520','مخزون - قطع غيار كمبيوتر','المخزون كاصل'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('1530'),array('accountcode','accountname','group_'),array('1530','مخزون - برامج','المخزون كاصل'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('1540'),array('accountcode','accountname','group_'),array('1540','مخزون - قطع اخرى','المخزون كاصل'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('1820'),array('accountcode','accountname','group_'),array('1820','اثاث مكتبى و معدات','الاصول الثابتة'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('1825'),array('accountcode','accountname','group_'),array('1825','مخصص اهلاك اثاث مكتبى و معدات','الاصول الثابتة'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('1840'),array('accountcode','accountname','group_'),array('1840','سيارات','الاصول الثابتة'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('1845'),array('accountcode','accountname','group_'),array('1845','مخصص اهلاك سيارات','الاصول الثابتة'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('2100'),array('accountcode','accountname','group_'),array('2100','موردين','التزامات قصيرة الاجل'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('2160'),array('accountcode','accountname','group_'),array('2160','ضريبة شركات مستحقة','التزامات قصيرة الاجل'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('2190'),array('accountcode','accountname','group_'),array('2190','ضريبة دخل مستحقة','التزامات قصيرة الاجل'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('2210'),array('accountcode','accountname','group_'),array('2210','Workers Comp Payable','التزامات قصيرة الاجل'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('2220'),array('accountcode','accountname','group_'),array('2220','Vacation Pay Payable','التزامات قصيرة الاجل'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('2250'),array('accountcode','accountname','group_'),array('2250','Pension Plan Payable','التزامات قصيرة الاجل'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('2260'),array('accountcode','accountname','group_'),array('2260','Employment Insurance Payable','التزامات قصيرة الاجل'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('2280'),array('accountcode','accountname','group_'),array('2280','ضرائب مرتبات مستحقة','التزامات قصيرة الاجل'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('2310'),array('accountcode','accountname','group_'),array('2310','ضريبة مبيعات (10%)','التزامات قصيرة الاجل'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('2320'),array('accountcode','accountname','group_'),array('2320','ضريبة مبيعات (14%)','التزامات قصيرة الاجل'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('2330'),array('accountcode','accountname','group_'),array('2330','ضريبة مبيعات (30%)','التزامات قصيرة الاجل'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('2620'),array('accountcode','accountname','group_'),array('2620','قروض من البنوك','التمات طويلة الاجل'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('2680'),array('accountcode','accountname','group_'),array('2680','قروض من حملة الاسهم','التمات طويلة الاجل'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('3350'),array('accountcode','accountname','group_'),array('3350','الاسهم','حقوق الملكية'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('4020'),array('accountcode','accountname','group_'),array('4020','مبيعات - قطع غيار','ايراد المبيعات'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('4030'),array('accountcode','accountname','group_'),array('4030','مبيعات برامج','ايراد المبيعات'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('4040'),array('accountcode','accountname','group_'),array('4040','مبيعات اخرى','ايراد المبيعات'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('4320'),array('accountcode','accountname','group_'),array('4320','استشارات','راد استشارات'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('4330'),array('accountcode','accountname','group_'),array('4330','برمجة','راد استشارات'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('4430'),array('accountcode','accountname','group_'),array('4430','شحن و تعبئة','ايردات اخرى'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('4440'),array('accountcode','accountname','group_'),array('4440','فائدة','ايردات اخرى'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('4450'),array('accountcode','accountname','group_'),array('4450','ارباح تغيير عملة','ايردات اخرى'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5010'),array('accountcode','accountname','group_'),array('5010','مشتريات','تكلفة البضاعة المباعة'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5020'),array('accountcode','accountname','group_'),array('5020','تكلفة البضاعة المباعة - قطع غيار','تكلفة البضاعة المباعة'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5030'),array('accountcode','accountname','group_'),array('5030','تكلفة البضاعة المباعة - برامج','تكلفة البضاعة المباعة'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5040'),array('accountcode','accountname','group_'),array('5040','تكلفة البضاعة المباعة - اخرى','تكلفة البضاعة المباعة'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5100'),array('accountcode','accountname','group_'),array('5100','شحن','تكلفة البضاعة المباعة'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5410'),array('accountcode','accountname','group_'),array('5410','المرتبات','مصروفات الاجور'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5420'),array('accountcode','accountname','group_'),array('5420','Employment Insurance Expense','مصروفات الاجور'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5430'),array('accountcode','accountname','group_'),array('5430','Pension Plan Expense','مصروفات الاجور'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5440'),array('accountcode','accountname','group_'),array('5440','Workers Comp Expense','مصروفات الاجور'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5470'),array('accountcode','accountname','group_'),array('5470','Employee Benefits','مصروفات الاجور'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5610'),array('accountcode','accountname','group_'),array('5610','قانونية و محاسبية','مصروفات ادارية و عمومية'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5615'),array('accountcode','accountname','group_'),array('5615','دعاية و اعلان','مصروفات ادارية و عمومية'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5620'),array('accountcode','accountname','group_'),array('5620','ديون معدومة','مصروفات ادارية و عمومية'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5650'),array('accountcode','accountname','group_'),array('5650','Capital Cost Allowance Expense','مصروفات ادارية و عمومية'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5660'),array('accountcode','accountname','group_'),array('5660','مصاريف اهلاك','مصروفات ادارية و عمومية'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5680'),array('accountcode','accountname','group_'),array('5680','ضريبة دخل','مصروفات ادارية و عمومية'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5685'),array('accountcode','accountname','group_'),array('5685','تامين','مصروفات ادارية و عمومية'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5690'),array('accountcode','accountname','group_'),array('5690','قوائد و مصاريف بنكية','مصروفات ادارية و عمومية'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5700'),array('accountcode','accountname','group_'),array('5700','مهمات مكتبية','مصروفات ادارية و عمومية'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5760'),array('accountcode','accountname','group_'),array('5760','ايجار','مصروفات ادارية و عمومية'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5765'),array('accountcode','accountname','group_'),array('5765','اصلاح و صيانة','مصروفات ادارية و عمومية'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5780'),array('accountcode','accountname','group_'),array('5780','تلفون','مصروفات ادارية و عمومية'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5785'),array('accountcode','accountname','group_'),array('5785','مصاريف سفر','مصروفات ادارية و عمومية'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5790'),array('accountcode','accountname','group_'),array('5790','مرافق','مصروفات ادارية و عمومية'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5795'),array('accountcode','accountname','group_'),array('5795','رسوم','مصروفات ادارية و عمومية'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5800'),array('accountcode','accountname','group_'),array('5800','رخص','مصروفات ادارية و عمومية'), $db);
InsertRecord('chartmaster',array('accountcaode'),array('5810'),array('accountcode','accountname','group_'),array('5810','خسارة تحويل عملة','مصروفات ادارية و عمومية'), $db);
?>