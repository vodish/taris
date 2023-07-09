
export function dataRequest(req)
{
    req.method        =   req.method ?? 'POST';
    req.fd            =   req.fd instanceof FormData?  req.fd :  new FormData();
    req.responseType  =   req.responseType ?? 'json';
    req.userHash      =   333;

    return new Promise((resolve) => {
        let xhr = new XMLHttpRequest();
        xhr.open(req.method, req.url);
        xhr.setRequestHeader('User-Hash', req.userHash);
        xhr.responseType = req.responseType;
        xhr.send(req.fd);
        xhr.onload = () => resolve(xhr.response);
        // console.log(req)
    });
}

