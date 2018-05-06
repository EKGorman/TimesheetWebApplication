var people, asc1 = 1,
            asc2 = 1,
            asc3 = 1,
            asc4 = 1,
            people1,
            asc5 = 1,
            asc6 = 1,
            asc7 = 1,
            people2,
            asc8 = 1;

        window.onload = function () {
            people = document.getElementById("people");
            people1 = document.getElementById("people1");
            people2 = document.getElementById("people2");
        }
        
        function sort_table(tbody, col, asc){
            var rows = tbody.rows, rlen = rows.length, arr = new Array(), i, j, cells, clen;
            // fill the array with values from the table
            for(i = 0; i < rlen; i++){
            cells = rows[i].cells;
            clen = cells.length;
            arr[i] = new Array();
                for(j = 0; j < clen; j++){
                arr[i][j] = cells[j].innerHTML;
                }
            }
            // sort the array by the specified column number (col) and order (asc)
            arr.sort(function(a, b){
                return (a[col] == b[col]) ? 0 : ((a[col] > b[col]) ? asc : -1*asc);
            });
            for(i = 0; i < rlen; i++){
                arr[i] = "<td>"+arr[i].join("</td><td>")+"</td>";
            }
            tbody.innerHTML = "<tr>"+arr.join("</tr><tr>")+"</tr>";
        }
        
        









        function myFunction() {
    document.getElementById("div2").style.display = "";  //Show the table
    document.getElementById("div1").style.display = "none";
    document.getElementById("div3").style.display = "none";
}
function myFunction2() {
  document.getElementById("div1").style.display = "";  //Show the table
    document.getElementById("div2").style.display = "none";
    document.getElementById("div3").style.display = "none";
}
function myFunction3() {
    document.getElementById("div3").style.display = "";  //Show the table
    document.getElementById("div2").style.display = "none";
    document.getElementById("div1").style.display = "none";
}