function handleChange1(){
var etl = {
    'RJ.ETL' : 'basic',
    'RJ.ETL.jdbc' : 'JDBC',
    'RJ.ETL.report' : 'Report',
    'RJ.ETL.driver' : 'Driver',
    'RJ.ETL.fileio' : 'fileio'


};
var rep = {
	'RJ4Salesforce.Enterprise':'Enterprise',
	'RJ4Salesforce.Warehouse':'Warehouse',
	'RJ4Salesforce.Basic':'Basic',
	'RJ4Salesforce.RTO':'RTO',
	'RJ4Pardot.Production':'RJ4Pardot',
	'RJ4NetSuite.Enterprise':'RJ4NetSuite'
};
 


                

                   
							 
var att = document.createAttribute("multiple");
var select = document.getElementById("bob");
var length = select.options.length;
while (select.firstChild) {
	select.removeChild(select.firstChild);
}
	var radios = document.getElementsByName('KeyType');

		for (var i = 0, length = radios.length; i < length; i++)
		{
			if (radios[i].checked)
			{

				if(document.querySelector('input[name="KeyType"]:checked').value=="ETL"){

					
					select.setAttributeNode(att)
					for(index in etl) {
					    select.options[select.options.length] = new Option(etl[index], index);
					}
				}else{

					select.removeAttribute("multiple");
					for(index in rep) {
					    select.options[select.options.length] = new Option(rep[index], index);
					}				
				}
			break;
			}
		}
}


