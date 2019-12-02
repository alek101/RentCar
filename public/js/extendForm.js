extendFormBlade={
    extendForm: function() 
                {document.querySelector('#dugme').addEventListener('click',function(e)
                    {
                        e.preventDefault();

                    let id=document.querySelector('#rez_id').value;
                        let brojDana=document.querySelector('#brojDana').value;
                        
                
                        let niz=
                        {
                            id:id,
                            brojDana:brojDana
                        }
                
                        console.log(niz);
                        
                        let opcije={
                            method: "POST",
                            body: JSON.stringify(niz),
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                                'Content-Type': 'application/json'   //BITNO!!!
                            }
                        }
                
                        fetch('/rezervacijeInfo/extendReservation',opcije)
                            .then(resp=>resp.text())
                            .then(txt=>ispisi(txt));
                    })

                    function ispisi(odgovor)
                    {          
                        document.querySelector('.response').innerHTML=`<a href="/rezervacijeInfo/all">${odgovor}</a>`;
                    }}
}