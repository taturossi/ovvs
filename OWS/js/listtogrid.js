(function () {
    $('#btnRightA').click(function (e) {
        var selectedOpts = $('#lstBoxAD option:selected');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }
        else
        {
            for(var i=0; i<selectedOpts.length; i++)
            {
                fillTR(selectedOpts[i].value, selectedOpts[i].text);
            }
        }

        
        //$('#lstBoxAA').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $('#btnAllRightA').click(function (e) {
        var selectedOpts = $('#lstBoxAD option');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }
        else
        {
            for(var i=0; i<selectedOpts.length; i++)
            {
                fillTR(selectedOpts[i].value, selectedOpts[i].text);
            }
        }

        //$('#lstBoxAA').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $('#btnLeftA').click(function (e) {
        var selectedOpts = getSelAnt();
        
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }
        else
        {
            for(var i=0; i<selectedOpts.length; i++)
            {
                remTRaddOPT(selectedOpts[i]);
            }
            
        }

        e.preventDefault();
    });

    $('#btnAllLeftA').click(function (e) {
        var selectedOpts = document.getElementById("tbAntenas").rows;
        
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }
        else
        {
            for(var i=0; i<selectedOpts.length; i++)
            {
                remTRaddOPT(selectedOpts[i]);
            }
        }
        e.preventDefault();
    });
}(jQuery));

function fillTR(val, text)
{
    var tb = document.getElementById("tbAntenas");
    
    $("#tbAntenas").find("tr.odd").remove();
    
    var rowTable=document.createElement("tr");
    rowTable.setAttribute('onclick', "selTR(this)");
    rowTable.setAttribute("class","dinamictr");

    colCodigo = document.createElement("td");
   
    colMod = document.createElement("td");
    colFrecs = document.createElement("td");
    colAB = document.createElement("td");
    colFrec = document.createElement("td");
        
    
    //Select de Mmodalidades
    var selMod = document.createElement("select");
    selMod.setAttribute('id', "selMods");
    selMod.setAttribute('class', "form-control select2-hidden-accessible");
    selMod.setAttribute('data-val', "true");
    selMod.setAttribute('tabindex', "-1");
    selMod.setAttribute('aria-hidden', "true");
    var optPP = document.createElement("option");
    optPP.setAttribute('value','PP');
    optPP.appendChild(document.createTextNode("PuntoPunto"));
    var optPM = document.createElement("option");
    optPM.setAttribute('value','PM');
    optPM.appendChild(document.createTextNode("PuntoMultipunto"));
    selMod.appendChild(optPP);
    selMod.appendChild(optPM);

    //Select de frecuencias
    var selFrecs = document.createElement("select");
    selFrecs.setAttribute('id', "selFrecs");
    selFrecs.setAttribute('class', "form-control select2-hidden-accessible");
    selFrecs.setAttribute('data-val', "true");
    selFrecs.setAttribute('tabindex', "-1");
    selFrecs.setAttribute('aria-hidden', "true");
    var optF1 = document.createElement("option");
    optF1.setAttribute('value','1');
    optF1.appendChild(document.createTextNode("5170-5240 MHz"));
    var optF2 = document.createElement("option");
    optF2.setAttribute('value','2');
    optF2.appendChild(document.createTextNode("5250-5330 MHz DFS"));
    var optF3 = document.createElement("option");
    optF3.setAttribute('value','3');
    optF3.appendChild(document.createTextNode("5480-5720 MHz DFS"));
    var optF4 = document.createElement("option");
    optF4.setAttribute('value','4');
    optF4.appendChild(document.createTextNode("5735-5895 MHz"));
    
    selFrecs.appendChild(optF1);
    selFrecs.appendChild(optF2);
    selFrecs.appendChild(optF3);
    selFrecs.appendChild(optF4);


    //Select de Anchos de banda
    //Select de frecuencias
    var selAB = document.createElement("select");
    selAB.setAttribute('id', "selAB");
    selAB.setAttribute('class', "form-control select2-hidden-accessible");
    selAB.setAttribute('data-val', "true");
    selAB.setAttribute('tabindex', "-1");
    selAB.setAttribute('aria-hidden', "true");
    var optAB1 = document.createElement("option");
    optAB1.setAttribute('value','10');
    optAB1.appendChild(document.createTextNode("10 MHz"));
    var optAB2 = document.createElement("option");
    optAB2.setAttribute('value','20');
    optAB2.appendChild(document.createTextNode("20 MHz"));
    var optAB3 = document.createElement("option");
    optAB3.setAttribute('value','30');
    optAB3.appendChild(document.createTextNode("30 MHz"));
    var optAB4 = document.createElement("option");
    optAB4.setAttribute('value','40');
    optAB4.appendChild(document.createTextNode("40 MHz"));
    var optAB5 = document.createElement("option");
    optAB5.setAttribute('value','50');
    optAB5.appendChild(document.createTextNode("50 MHz"));
    var optAB6 = document.createElement("option");
    optAB6.setAttribute('value','60');
    optAB6.appendChild(document.createTextNode("60 MHz"));
    var optAB8 = document.createElement("option");
    optAB8.setAttribute('value','80');
    optAB8.appendChild(document.createTextNode("80 MHz"));
    var optAB16 = document.createElement("option");
    optAB16.setAttribute('value','160');
    optAB16.appendChild(document.createTextNode("160 MHz"));
    

    selAB.appendChild(optAB1);
    selAB.appendChild(optAB2);
    selAB.appendChild(optAB3);
    selAB.appendChild(optAB4);
    selAB.appendChild(optAB5);
    selAB.appendChild(optAB6);
    selAB.appendChild(optAB8);
    selAB.appendChild(optAB16);
    
    //Input de frecuencia especifica
    var txtFrec = document.createElement("input");
    selMod.setAttribute('id', "txtFrec");
    selMod.setAttribute('class', "form-control");
    
    //Input con id
    var hdn = document.createElement("input");
    hdn.setAttribute('type', "hidden");
    hdn.setAttribute('id', "hdnidant");
    hdn.setAttribute("value",val);
    
    
    colCodigo.appendChild(hdn);
    colCodigo.appendChild(document.createTextNode(text));
    colMod.appendChild(selMod);
    colFrecs.appendChild(selFrecs);
    colAB.appendChild(selAB);
    colFrec.appendChild(txtFrec);
    
    rowTable.appendChild(colCodigo);
    rowTable.appendChild(colMod);
    rowTable.appendChild(colFrecs);
    rowTable.appendChild(colAB);
    rowTable.appendChild(colFrec);
    
    tb.appendChild(rowTable);

   
}
function addEmptyRow(tb)
{
    tb.innerHTML = '<tr class="odd"><td valign="top" colspan="5" class="dataTables_empty">No existe información para mostrar.</td></tr>';
    
}
function  remTRaddOPT(objtr)
{
    var imp = objtr.childNodes[0].childNodes[0];
    var val = objtr.childNodes[0].childNodes[1];

    var  opt = document.createElement("option");
    opt.setAttribute('value',imp.value);
    opt.appendChild(document.createTextNode(val.data));

    $('#lstBoxAD').append(opt);
    
    objtr.remove();
    var tb = document.getElementById("tbAntenas");
    if(tb.childNodes.length == 0)
    {
        addEmptyRow(tb);    
    }

    
}
function getSelAnt()
{
    var tb = document.getElementById("tbAntenas");

    var i = 0;
    var seltr = [];
    for(i=0; i < tb.rows.length; i++)
    {
        var val1 = getBgColorHex(tb.rows[i]);
        if(val1 == "#c6e1f7")
            seltr[i] = tb.rows[i];
    }    
    return seltr;
}

function selTR(objRow)
{
    var color = getBgColorHex(objRow);
    if(color == "#c6e1f7")
        objRow.setAttribute("style","background-color:#ffffff");
    else
        objRow.setAttribute("style","background-color:#c6e1f7");
}
function getBgColorHex(elem){
    var color = elem.style.backgroundColor;
    var hex;
    if(color.indexOf('#')>-1){
        //for IE
        hex = color;
    } 
    else if(color != "")
    {
        var rgb = color.match(/\d+/g);
        hex = '#'+ ('0' + parseInt(rgb[0], 10).toString(16)).slice(-2) + ('0' + parseInt(rgb[1], 10).toString(16)).slice(-2) + ('0' + parseInt(rgb[2], 10).toString(16)).slice(-2);
    }
    return hex;
}