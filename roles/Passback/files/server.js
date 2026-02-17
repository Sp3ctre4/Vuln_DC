const express = require('express');
const ldap = require('ldapjs');
const bodyParser = require('body-parser');
const app = express();
const path = require('path');

app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'ldap_connect.html'));
});

app.use(bodyParser.json());

app.post('/connect-ldap', (req, res) => {
    const { ip, port, username, password } = req.body;

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

app.listen(3000, () => {
    console.log('Spanreed server running on port 3000');
});
