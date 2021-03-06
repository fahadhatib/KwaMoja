<?php
InsertRecord('accountsection',array('sectionid'),array(10),array('sectionid','sectionname'),array(10,'Aktiven'));
InsertRecord('accountsection',array('sectionid'),array(20),array('sectionid','sectionname'),array(20,'Passiven'));
InsertRecord('accountsection',array('sectionid'),array(30),array('sectionid','sectionname'),array(30,'Erfolg'));
InsertRecord('accountsection',array('sectionid'),array(40),array('sectionid','sectionname'),array(40,'Aufwand'));
InsertRecord('accountgroups',array('groupname'),array('ANLAGEVERM'),array('groupcode', 'groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname','parentgroupcode'),array('10','ANLAGEVERM','10','0','1000','',''));
InsertRecord('accountgroups',array('groupname'),array('Ausserordentl.Ertr'),array('groupcode', 'groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname','parentgroupcode'),array('20','Ausserordentl.Ertr','30','1','18000','',''));
InsertRecord('accountgroups',array('groupname'),array('EIGENKAPITAL'),array('groupcode', 'groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname','parentgroupcode'),array('30','EIGENKAPITAL','20','0','5000','',''));
InsertRecord('accountgroups',array('groupname'),array('ERTR'),array('groupcode', 'groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname','parentgroupcode'),array('40','ERTR','30','1','14000','',''));
InsertRecord('accountgroups',array('groupname'),array('FORDERUNGEN'),array('groupcode', 'groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname','parentgroupcode'),array('50','FORDERUNGEN','10','0','3000','',''));
InsertRecord('accountgroups',array('groupname'),array('FREMDKAPITAL KURZFRISTIG'),array('groupcode', 'groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname','parentgroupcode'),array('60','FREMDKAPITAL KURZFRISTIG','20','0','8000','',''));
InsertRecord('accountgroups',array('groupname'),array('FREMDKAPITAL LANGFRISTIG'),array('groupcode', 'groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname','parentgroupcode'),array('70','FREMDKAPITAL LANGFRISTIG','20','0','7000','',''));
InsertRecord('accountgroups',array('groupname'),array('Guthabenzinsen'),array('groupcode', 'groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname','parentgroupcode'),array('80','Guthabenzinsen','30','1','17000','',''));
InsertRecord('accountgroups',array('groupname'),array('LIQUIDE MITTEL'),array('groupcode', 'groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname','parentgroupcode'),array('90','LIQUIDE MITTEL','10','0','4000','',''));
InsertRecord('accountgroups',array('groupname'),array('NEUTRALE AUFWENDUNGEN'),array('groupcode', 'groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname','parentgroupcode'),array('100','NEUTRALE AUFWENDUNGEN','40','1','15000','',''));
InsertRecord('accountgroups',array('groupname'),array('NEUTRALE ERTR'),array('groupcode', 'groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname','parentgroupcode'),array('110','NEUTRALE ERTR','30','1','16000','',''));
InsertRecord('accountgroups',array('groupname'),array('PERSONALKOSTEN'),array('groupcode', 'groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname','parentgroupcode'),array('120','PERSONALKOSTEN','40','1','11000','',''));
InsertRecord('accountgroups',array('groupname'),array('R'),array('groupcode', 'groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname','parentgroupcode'),array('130','R','20','0','6000','',''));
InsertRecord('accountgroups',array('groupname'),array('RAUMKOSTEN'),array('groupcode', 'groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname','parentgroupcode'),array('140','RAUMKOSTEN','40','1','12000','',''));
InsertRecord('accountgroups',array('groupname'),array('SONSTIGE KOSTEN'),array('groupcode', 'groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname','parentgroupcode'),array('150','SONSTIGE KOSTEN','40','1','13000','',''));
InsertRecord('accountgroups',array('groupname'),array('WARENBESTAND'),array('groupcode', 'groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname','parentgroupcode'),array('160','WARENBESTAND','10','0','2000','',''));
InsertRecord('accountgroups',array('groupname'),array('WARENEINGANG'),array('groupcode', 'groupname','sectioninaccounts','pandl','sequenceintb','parentgroupname','parentgroupcode'),array('170','WARENEINGANG','40','1','9000','',''));
InsertRecord('chartmaster',array('accountcode'),array('0100'),array('accountcode','accountname','group_'),array('0100','Konzessionen & Lizenzen','ANLAGEVERM'));
InsertRecord('chartmaster',array('accountcode'),array('0135'),array('accountcode','accountname','group_'),array('0135','EDV-Programme','ANLAGEVERM'));
InsertRecord('chartmaster',array('accountcode'),array('0440'),array('accountcode','accountname','group_'),array('0440','Maschinen','ANLAGEVERM'));
InsertRecord('chartmaster',array('accountcode'),array('0500'),array('accountcode','accountname','group_'),array('0500','Betriebsausstattung','ANLAGEVERM'));
InsertRecord('chartmaster',array('accountcode'),array('0520'),array('accountcode','accountname','group_'),array('0520','PKW','ANLAGEVERM'));
InsertRecord('chartmaster',array('accountcode'),array('0650'),array('accountcode','accountname','group_'),array('0650','B','ANLAGEVERM'));
InsertRecord('chartmaster',array('accountcode'),array('0670'),array('accountcode','accountname','group_'),array('0670','GWG','ANLAGEVERM'));
InsertRecord('chartmaster',array('accountcode'),array('1140'),array('accountcode','accountname','group_'),array('1140','Warenbestand','WARENBESTAND'));
InsertRecord('chartmaster',array('accountcode'),array('1201'),array('accountcode','accountname','group_'),array('1201','Geleistete Anzahlungen','FORDERUNGEN'));
InsertRecord('chartmaster',array('accountcode'),array('1210'),array('accountcode','accountname','group_'),array('1210','Forderungen ohne Kontokorrent','FORDERUNGEN'));
InsertRecord('chartmaster',array('accountcode'),array('1300'),array('accountcode','accountname','group_'),array('1300','Sonstige Forderungen','FORDERUNGEN'));
InsertRecord('chartmaster',array('accountcode'),array('1370'),array('accountcode','accountname','group_'),array('1370','Ungekl','FORDERUNGEN'));
InsertRecord('chartmaster',array('accountcode'),array('1400'),array('accountcode','accountname','group_'),array('1400','Anrechenbare Vorsteuer','FORDERUNGEN'));
InsertRecord('chartmaster',array('accountcode'),array('1401'),array('accountcode','accountname','group_'),array('1401','Anrechenbare Vorsteuer 7%','FORDERUNGEN'));
InsertRecord('chartmaster',array('accountcode'),array('1402'),array('accountcode','accountname','group_'),array('1402','Vorsteuer ig Erwerb','FORDERUNGEN'));
InsertRecord('chartmaster',array('accountcode'),array('1403'),array('accountcode','accountname','group_'),array('1403','Vorsteuer ig Erwerb 16%','FORDERUNGEN'));
InsertRecord('chartmaster',array('accountcode'),array('1405'),array('accountcode','accountname','group_'),array('1405','Anrechenbare Vorsteuer 16%','FORDERUNGEN'));
InsertRecord('chartmaster',array('accountcode'),array('1406'),array('accountcode','accountname','group_'),array('1406','Anrechenbare Vorsteuer 15%','FORDERUNGEN'));
InsertRecord('chartmaster',array('accountcode'),array('1433'),array('accountcode','accountname','group_'),array('1433','bezahlte Einfuhrumsatzsteuer','FORDERUNGEN'));
InsertRecord('chartmaster',array('accountcode'),array('1601'),array('accountcode','accountname','group_'),array('1601','Kasse','LIQUIDE MITTEL'));
InsertRecord('chartmaster',array('accountcode'),array('1700'),array('accountcode','accountname','group_'),array('1700','Postgiro','LIQUIDE MITTEL'));
InsertRecord('chartmaster',array('accountcode'),array('1800'),array('accountcode','accountname','group_'),array('1800','Bank','LIQUIDE MITTEL'));
InsertRecord('chartmaster',array('accountcode'),array('1810'),array('accountcode','accountname','group_'),array('1810','Bank USD','LIQUIDE MITTEL'));
InsertRecord('chartmaster',array('accountcode'),array('1820'),array('accountcode','accountname','group_'),array('1820','Kreditkarten','LIQUIDE MITTEL'));
InsertRecord('chartmaster',array('accountcode'),array('1890'),array('accountcode','accountname','group_'),array('1890','Geldtransit','LIQUIDE MITTEL'));
InsertRecord('chartmaster',array('accountcode'),array('1900'),array('accountcode','accountname','group_'),array('1900','Aktive Rechnungsabgrenzung','LIQUIDE MITTEL'));
InsertRecord('chartmaster',array('accountcode'),array('2001'),array('accountcode','accountname','group_'),array('2001','Eigenkapital','EIGENKAPITAL'));
InsertRecord('chartmaster',array('accountcode'),array('2100'),array('accountcode','accountname','group_'),array('2100','Privatentnahmen','EIGENKAPITAL'));
InsertRecord('chartmaster',array('accountcode'),array('2150'),array('accountcode','accountname','group_'),array('2150','Privatsteuern','EIGENKAPITAL'));
InsertRecord('chartmaster',array('accountcode'),array('2180'),array('accountcode','accountname','group_'),array('2180','Privateinlagen','EIGENKAPITAL'));
InsertRecord('chartmaster',array('accountcode'),array('2200'),array('accountcode','accountname','group_'),array('2200','Sonderausgaben beschr.abzugsf.','EIGENKAPITAL'));
InsertRecord('chartmaster',array('accountcode'),array('2900'),array('accountcode','accountname','group_'),array('2900','Gezeichnetes Kapital','EIGENKAPITAL'));
InsertRecord('chartmaster',array('accountcode'),array('2910'),array('accountcode','accountname','group_'),array('2910','Ausstehende Einlagen','EIGENKAPITAL'));
InsertRecord('chartmaster',array('accountcode'),array('2970'),array('accountcode','accountname','group_'),array('2970','Gewinnvortrag vor Verwendung','EIGENKAPITAL'));
InsertRecord('chartmaster',array('accountcode'),array('2978'),array('accountcode','accountname','group_'),array('2978','Verlustvortrag vor Verwendung','EIGENKAPITAL'));
InsertRecord('chartmaster',array('accountcode'),array('3030'),array('accountcode','accountname','group_'),array('3030','Gewerbesteuerr','R'));
InsertRecord('chartmaster',array('accountcode'),array('3070'),array('accountcode','accountname','group_'),array('3070','Sonstige R','R'));
InsertRecord('chartmaster',array('accountcode'),array('3095'),array('accountcode','accountname','group_'),array('3095','R','R'));
InsertRecord('chartmaster',array('accountcode'),array('3160'),array('accountcode','accountname','group_'),array('3160','Bankdarlehen','FREMDKAPITAL LANGFRISTIG'));
InsertRecord('chartmaster',array('accountcode'),array('3280'),array('accountcode','accountname','group_'),array('3280','Erhaltene Anzahlungen','FREMDKAPITAL KURZFRISTIG'));
InsertRecord('chartmaster',array('accountcode'),array('3310'),array('accountcode','accountname','group_'),array('3310','Kreditoren ohne Kontokorrent','FREMDKAPITAL KURZFRISTIG'));
InsertRecord('chartmaster',array('accountcode'),array('3500'),array('accountcode','accountname','group_'),array('3500','Sonstige Verbindlichkeiten','FREMDKAPITAL KURZFRISTIG'));
InsertRecord('chartmaster',array('accountcode'),array('3560'),array('accountcode','accountname','group_'),array('3560','Darlehen','FREMDKAPITAL KURZFRISTIG'));
InsertRecord('chartmaster',array('accountcode'),array('3700'),array('accountcode','accountname','group_'),array('3700','Verbindl. Betr.steuern u.Abgaben','FREMDKAPITAL KURZFRISTIG'));
InsertRecord('chartmaster',array('accountcode'),array('3720'),array('accountcode','accountname','group_'),array('3720','Verbindlichkeiten L','FREMDKAPITAL KURZFRISTIG'));
InsertRecord('chartmaster',array('accountcode'),array('3730'),array('accountcode','accountname','group_'),array('3730','Verbindlichkeiten Lohnsteuer','FREMDKAPITAL KURZFRISTIG'));
InsertRecord('chartmaster',array('accountcode'),array('3740'),array('accountcode','accountname','group_'),array('3740','Verbindlichkeiten Sozialversicherung','FREMDKAPITAL KURZFRISTIG'));
InsertRecord('chartmaster',array('accountcode'),array('3800'),array('accountcode','accountname','group_'),array('3800','Umsatzsteuer','FREMDKAPITAL KURZFRISTIG'));
InsertRecord('chartmaster',array('accountcode'),array('3801'),array('accountcode','accountname','group_'),array('3801','Umsatzsteuer 7%','FREMDKAPITAL KURZFRISTIG'));
InsertRecord('chartmaster',array('accountcode'),array('3802'),array('accountcode','accountname','group_'),array('3802','Umsatzsteuer ig. Erwerb','FREMDKAPITAL KURZFRISTIG'));
InsertRecord('chartmaster',array('accountcode'),array('3803'),array('accountcode','accountname','group_'),array('3803','Umsatzsteuer ig. Erwerb 16%','FREMDKAPITAL KURZFRISTIG'));
InsertRecord('chartmaster',array('accountcode'),array('3805'),array('accountcode','accountname','group_'),array('3805','Umsatzsteuer 16%','FREMDKAPITAL KURZFRISTIG'));
InsertRecord('chartmaster',array('accountcode'),array('3806'),array('accountcode','accountname','group_'),array('3806','Umsatzsteuer 15%','FREMDKAPITAL KURZFRISTIG'));
InsertRecord('chartmaster',array('accountcode'),array('3815'),array('accountcode','accountname','group_'),array('3815','Umsatzsteuer nicht f','FREMDKAPITAL KURZFRISTIG'));
InsertRecord('chartmaster',array('accountcode'),array('3816'),array('accountcode','accountname','group_'),array('3816','Umsatzsteuer nicht f','FREMDKAPITAL KURZFRISTIG'));
InsertRecord('chartmaster',array('accountcode'),array('3820'),array('accountcode','accountname','group_'),array('3820','Umsatzsteuer-Vorauszahlungen','FREMDKAPITAL KURZFRISTIG'));
InsertRecord('chartmaster',array('accountcode'),array('3841'),array('accountcode','accountname','group_'),array('3841','Umsatzsteuer Vorjahr','FREMDKAPITAL KURZFRISTIG'));
InsertRecord('chartmaster',array('accountcode'),array('3900'),array('accountcode','accountname','group_'),array('3900','Aktive Rechnungsabgrenzung','FREMDKAPITAL KURZFRISTIG'));
InsertRecord('chartmaster',array('accountcode'),array('5200'),array('accountcode','accountname','group_'),array('5200','Wareneingang ohne Vorsteuer','WARENEINGANG'));
InsertRecord('chartmaster',array('accountcode'),array('5300'),array('accountcode','accountname','group_'),array('5300','Wareneingang 7%','WARENEINGANG'));
InsertRecord('chartmaster',array('accountcode'),array('5400'),array('accountcode','accountname','group_'),array('5400','Wareneingang 15%','WARENEINGANG'));
InsertRecord('chartmaster',array('accountcode'),array('5420'),array('accountcode','accountname','group_'),array('5420','ig.Erwerb 7% VoSt. und 7% USt.','WARENEINGANG'));
InsertRecord('chartmaster',array('accountcode'),array('5425'),array('accountcode','accountname','group_'),array('5425','ig.Erwerb 15% VoSt. und 15% USt.','WARENEINGANG'));
InsertRecord('chartmaster',array('accountcode'),array('5731'),array('accountcode','accountname','group_'),array('5731','Erhaltene Skonti 7% Vorsteuer','WARENEINGANG'));
InsertRecord('chartmaster',array('accountcode'),array('5736'),array('accountcode','accountname','group_'),array('5736','Erhaltene Skonti 15% Vorsteuer','WARENEINGANG'));
InsertRecord('chartmaster',array('accountcode'),array('5800'),array('accountcode','accountname','group_'),array('5800','Anschaffungsnebenkosten','WARENEINGANG'));
InsertRecord('chartmaster',array('accountcode'),array('5900'),array('accountcode','accountname','group_'),array('5900','Fremdarbeiten','WARENEINGANG'));
InsertRecord('chartmaster',array('accountcode'),array('6010'),array('accountcode','accountname','group_'),array('6010','L','PERSONALKOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6020'),array('accountcode','accountname','group_'),array('6020','Geh','PERSONALKOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6030'),array('accountcode','accountname','group_'),array('6030','Aushilfsl','PERSONALKOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6040'),array('accountcode','accountname','group_'),array('6040','Lohnsteuer Aushilfen','PERSONALKOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6080'),array('accountcode','accountname','group_'),array('6080','Verm','PERSONALKOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6090'),array('accountcode','accountname','group_'),array('6090','Fahrtkostenerst.Whg./Arbeitsst','PERSONALKOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6110'),array('accountcode','accountname','group_'),array('6110','Sozialversicherung','PERSONALKOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6120'),array('accountcode','accountname','group_'),array('6120','Berufsgenossenschaft','PERSONALKOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6130'),array('accountcode','accountname','group_'),array('6130','Freiw. Soz. Aufw. LSt- u. Soz.Vers.frei','PERSONALKOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6310'),array('accountcode','accountname','group_'),array('6310','Miete','RAUMKOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6315'),array('accountcode','accountname','group_'),array('6315','Pacht','RAUMKOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6320'),array('accountcode','accountname','group_'),array('6320','Heizung','RAUMKOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6325'),array('accountcode','accountname','group_'),array('6325','Gas Strom Wasser','RAUMKOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6330'),array('accountcode','accountname','group_'),array('6330','Reinigung','RAUMKOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6335'),array('accountcode','accountname','group_'),array('6335','Instandhaltung betriebliche R','RAUMKOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6345'),array('accountcode','accountname','group_'),array('6345','Sonstige Raumkosten','RAUMKOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6402'),array('accountcode','accountname','group_'),array('6402','Abschreibungen','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6403'),array('accountcode','accountname','group_'),array('6403','Kaufleasing','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6404'),array('accountcode','accountname','group_'),array('6404','Sofortabschreibung GWG','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6405'),array('accountcode','accountname','group_'),array('6405','Sonstige Kosten','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6410'),array('accountcode','accountname','group_'),array('6410','Versicherung','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6420'),array('accountcode','accountname','group_'),array('6420','Beitr','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6430'),array('accountcode','accountname','group_'),array('6430','Sonstige Abgaben','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6470'),array('accountcode','accountname','group_'),array('6470','Rep. und Instandhaltung BGA','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6520'),array('accountcode','accountname','group_'),array('6520','Kfz-Versicherung','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6530'),array('accountcode','accountname','group_'),array('6530','Lfd. Kfz-Kosten','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6540'),array('accountcode','accountname','group_'),array('6540','Kfz-Reparaturen','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6560'),array('accountcode','accountname','group_'),array('6560','Fremdfahrzeuge','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6570'),array('accountcode','accountname','group_'),array('6570','Sonstige Kfz-Kosten','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6600'),array('accountcode','accountname','group_'),array('6600','Werbung','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6610'),array('accountcode','accountname','group_'),array('6610','Kundengeschenke bis DM 75.','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6620'),array('accountcode','accountname','group_'),array('6620','Kundengeschenke','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6630'),array('accountcode','accountname','group_'),array('6630','Repr','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6640'),array('accountcode','accountname','group_'),array('6640','Bewirtungskosten','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6644'),array('accountcode','accountname','group_'),array('6644','Nicht abzugsf.Bewirtungskosten','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6650'),array('accountcode','accountname','group_'),array('6650','Reisekosten Arbeitnehmer','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6660'),array('accountcode','accountname','group_'),array('6660','Reisekosten Arbeitnehmer 12.3%','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6665'),array('accountcode','accountname','group_'),array('6665','Reisekosten Arbeitnehmer 9.8%','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6670'),array('accountcode','accountname','group_'),array('6670','Reisekosten Unternehmer','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6680'),array('accountcode','accountname','group_'),array('6680','Reisekosten Unternehmer 12.3%','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6685'),array('accountcode','accountname','group_'),array('6685','Reisekosten Unternehmer 9.8%','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6688'),array('accountcode','accountname','group_'),array('6688','Reisekosten Unternehmer 5.7%','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6690'),array('accountcode','accountname','group_'),array('6690','Km-Geld-Erstattung 8.2%','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6710'),array('accountcode','accountname','group_'),array('6710','Verpackungsmaterial','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6740'),array('accountcode','accountname','group_'),array('6740','Ausgangsfrachten','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6780'),array('accountcode','accountname','group_'),array('6780','Fremdarbeiten','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6800'),array('accountcode','accountname','group_'),array('6800','Porto','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6805'),array('accountcode','accountname','group_'),array('6805','Telefon','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6815'),array('accountcode','accountname','group_'),array('6815','B','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6820'),array('accountcode','accountname','group_'),array('6820','Zeitschriften & B','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6825'),array('accountcode','accountname','group_'),array('6825','Rechts- und Beratungskosten','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6835'),array('accountcode','accountname','group_'),array('6835','Mieten f','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6840'),array('accountcode','accountname','group_'),array('6840','Mietleasing','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6845'),array('accountcode','accountname','group_'),array('6845','Werkzeuge und Kleinger','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6850'),array('accountcode','accountname','group_'),array('6850','Betriebsbedarf','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6852'),array('accountcode','accountname','group_'),array('6852','Gast','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6855'),array('accountcode','accountname','group_'),array('6855','Nebenkosten des Geldverkehrs','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6880'),array('accountcode','accountname','group_'),array('6880','Aufwendungen aus Kursdifferenzen','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('6885'),array('accountcode','accountname','group_'),array('6885','Erl','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('7610'),array('accountcode','accountname','group_'),array('7610','Gewerbesteuer','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('7685'),array('accountcode','accountname','group_'),array('7685','Kfz-Steuer','SONSTIGE KOSTEN'));
InsertRecord('chartmaster',array('accountcode'),array('8120'),array('accountcode','accountname','group_'),array('8120','Steuerfreie Ums','ERTR'));
InsertRecord('chartmaster',array('accountcode'),array('8125'),array('accountcode','accountname','group_'),array('8125','Steuerfreie ig. Lieferungen 1b UStG.','ERTR'));
InsertRecord('chartmaster',array('accountcode'),array('8200'),array('accountcode','accountname','group_'),array('8200','Erl','ERTR'));
InsertRecord('chartmaster',array('accountcode'),array('8300'),array('accountcode','accountname','group_'),array('8300','Erl','ERTR'));
InsertRecord('chartmaster',array('accountcode'),array('8400'),array('accountcode','accountname','group_'),array('8400','Erl','ERTR'));
InsertRecord('chartmaster',array('accountcode'),array('8500'),array('accountcode','accountname','group_'),array('8500','Provisionserl','ERTR'));
InsertRecord('chartmaster',array('accountcode'),array('8630'),array('accountcode','accountname','group_'),array('8630','Entnahme sonstg. Leistungen 7% USt.','ERTR'));
InsertRecord('chartmaster',array('accountcode'),array('8640'),array('accountcode','accountname','group_'),array('8640','Entnahme sonstg. Leistungen 15% USt.','ERTR'));
InsertRecord('chartmaster',array('accountcode'),array('8731'),array('accountcode','accountname','group_'),array('8731','Gew. Skonti 7% USt.','ERTR'));
InsertRecord('chartmaster',array('accountcode'),array('8736'),array('accountcode','accountname','group_'),array('8736','Gew. Skonti 15% USt.','ERTR'));
InsertRecord('chartmaster',array('accountcode'),array('8840'),array('accountcode','accountname','group_'),array('8840','Ertr','ERTR'));
InsertRecord('chartmaster',array('accountcode'),array('8845'),array('accountcode','accountname','group_'),array('8845','Erl','ERTR'));
InsertRecord('chartmaster',array('accountcode'),array('8900'),array('accountcode','accountname','group_'),array('8900','Ertr','ERTR'));
InsertRecord('chartmaster',array('accountcode'),array('9310'),array('accountcode','accountname','group_'),array('9310','Zinsen kurzfr. Verbindlichkeiten','NEUTRALE AUFWENDUNGEN'));
InsertRecord('chartmaster',array('accountcode'),array('9320'),array('accountcode','accountname','group_'),array('9320','Zinsen langfr. Verbindlichkeiten','NEUTRALE AUFWENDUNGEN'));
InsertRecord('chartmaster',array('accountcode'),array('9500'),array('accountcode','accountname','group_'),array('9500','Ausserordentl.Aufwendungen','NEUTRALE AUFWENDUNGEN'));
?>