const express = require('express');
const ldap = require('ldapjs');
const bodyParser = require('body-parser');
const app = express();
const path = require('path');

app.use(bodyParser.json());

app.use(express.static(path.join(__dirname, 'public')));



app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'index.html'));
});

app.get('/spanreed', (req, res) => {
    res.sendFile(path.join(__dirname, 'public', 'spanreed.html'));
});

app.post('/connect-ldap', (req, res) => {

    const { ip, port } = req.body;
    const username = "svc_spanreed";
    const password = "G82_10Lp19o1";

    const client = ldap.createClient({
        url: `ldap://${ip}:${port}`
    });

    client.bind(username, password, (err) => {
        if (err) {
            res.json({ success: false, error: err.message });
        } else {
            res.json({ success: true });
        }
        client.unbind();
    });
});

app.listen(80, () => {
    console.log('Spanreed server running on port 3000');
});
