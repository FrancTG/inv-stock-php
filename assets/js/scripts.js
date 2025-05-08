function readDocData(){
    if (oXML.readyState == 4) {
        let xml = oXML.responseXML;
        console.log(xml)
        let tabla = document.getElementById('document-container');
        let definicion_tabla = new String("");
        let v;
        let item;
        definicion_tabla += "<table><tr><th>ID</th><th>Reference</th><th>Date</th><th>Name</th><th>Total</th><th>Detalles</th></tr>"
        for (i = 0; i < xml.getElementsByTagName('document').length; i++){
            definicion_tabla = definicion_tabla + "<tr'>";
            item = xml.getElementsByTagName('document')[i];

            v = item.getElementsByTagName('id')[0].firstChild.data;
            definicion_tabla += "<td>" + v + "</td>";
            let id = v;

            v = item.getElementsByTagName('ref')[0].firstChild.data;
            definicion_tabla += "<td>" + v + "</td>";

            v = item.getElementsByTagName('date')[0].firstChild.data;
            definicion_tabla += "<td>" + v + "</td>";

            v = item.getElementsByTagName('client-name')[0].firstChild.data;
            definicion_tabla += "<td>" + v + ": ";

            v = item.getElementsByTagName('company')[0].firstChild.data;
            definicion_tabla += v + "</td>";

            v = item.getElementsByTagName('total')[0].firstChild.data;
            definicion_tabla += "<td>" + v + "</td>";

            definicion_tabla += "<td><a href='./details.php?id=" + id + "'>Ver</a></td>";


            definicion_tabla = definicion_tabla+"</tr></table";
        }
        tabla.innerHTML = definicion_tabla;
    }
}

function showDocuments(docType, data) {
    oXML = new XMLHttpRequest();
    oXML.open('POST', '/inv-stock-php/src/get-documents.php');
    oXML.responseType = "document";
    oXML.overrideMimeType("application/xml");
    oXML.onreadystatechange = readDocData;
    oXML.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    oXML.send('data=' + data + '&docType='+docType);
}