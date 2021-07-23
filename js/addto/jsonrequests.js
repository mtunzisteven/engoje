
export function jsonRequest(url, bodyData, countEl, mcountEl, countStr, responseEl, responseStr){

    fetch(url, {
        method: 'POST',
        body: bodyData
    })
    .then(response=>{
        if(response.ok){
            return response;
        }
        throw Error(response.statusText);
    })
    .then(response=>response.json())
    .then(data=>{

        let response = data[countStr];

        countEl.innerHTML = response;
        mcountEl.innerHTML = response;

        responseEl.innerHTML = data[responseStr];

    }) 
    .catch(error => console.log('Error Connecting!'))
}