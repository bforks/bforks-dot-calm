
/**
 * Module dependencies.
 */

var express = require('express')
  , http = require('http')
  , path = require('path')
  , util = require('util')
  , OAuth = require('oauth').OAuth;

var app = express();
var fmt = util.format;

// all environments
app.set('port', process.env.PORT || 6969);
app.set('views', __dirname + '/views');
app.set('view engine', 'ejs');
app.use(express.favicon());
app.use(express.logger('dev'));
app.use(express.bodyParser());
app.use(express.methodOverride());
app.use(express.cookieParser('twitteroauth'));
app.use(express.session());

// auth middleware needs to run before app.router
app.use(app.router);

app.use(express.static(path.join(__dirname, 'public')));

// development only
if ('development' == app.get('env')) {
  app.use(express.errorHandler());
}

var oauth_schemes = {
  'twitter': {
    'request_url': 'https://api.twitter.com/oauth/request_token',
    'access_url': 'https://api.twitter.com/oauth/access_token',
    'version': '1.0',
    'hash_algo': 'HMAC-SHA1'
  }
};

function makeOAuth(key, secret) {
  var scheme = oauth_schemes['twitter'];
  return new OAuth(
    scheme.request_url,
    scheme.access_url,
    key,
    secret,
    scheme.version,
    'http://127.0.0.1:6969/oauth/callback',
    scheme.hash_algo
  );
}

function oauthConnect(req, res, next) {
  var oa = makeOAuth(req.query.consumerkey, req.query.consumersecret);
  oa.getOAuthRequestToken(function(err, token, tokenSecret, results) {
    if (err) {
      console.log(err);
      res.send('token request failure: ' + err);
    } else {
      // wait until the session has been regenerated to redirect the user
      req.session.regenerate(function() {
        req.session.oauth = { };
        req.session.oauth.consumerkey = req.query.consumerkey;
        req.session.oauth.consumersecret = req.query.consumersecret;
        req.session.oauth.token = token;
        req.session.oauth.tokenSecret = tokenSecret;

        console.log(req.session);

        setTimeout(function() {
          res.redirect('https://twitter.com/oauth/authenticate?oauth_token=' + token);
        }, 500);
      });
    }
  });
}

function oauthCallback(req, res, next) {
  if (req.session.oauth) {
    req.session.oauth.verifier = req.query.oauth_verifier;

    var oauth = req.session.oauth;
    var oa = makeOAuth(oauth.consumerkey, oauth.consumersecret);

    oa.getOAuthAccessToken(oauth.token, oauth.tokenSecret, oauth.verifier,
    function(err, accessToken, accessTokenSecret, results) {
      if (err) {
        console.log(err);
        res.send('callback failure: ' + err);
      } else {
        console.log('user id: ' + results.user_id);
        console.log('user screen name: ' + results.screen_name);
        console.log('user access token: ' + accessToken);
        console.log('user access token secret: ' + accessTokenSecret);

        res.render('callback', {
          user_id: results.user_id,
          screen_name: results.screen_name,
          access_token: accessToken,
          access_token_secret: accessTokenSecret
        });
      }
    });
  } else {
    next(new Error('oauth token not found in session'));
  }
}

app.get('/', function(req, res, next) {
  res.render('index', {});
});

app.get('/oauth/connect', oauthConnect);
app.get('/oauth/callback', oauthCallback);

http.createServer(app).listen(app.get('port'), function(){
  console.log('oauth-helper listening on port ' + app.get('port'));
});
