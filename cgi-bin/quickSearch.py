import twitter
import json
import io

def oauth_login():
    
    CONSUMER_KEY = 'XXgXT3xLUOV9VfyZIHkZw'
    CONSUMER_SECRET = 'KtZ2QkB7bHDEAf4A01uVA5XQGkMc3k4UjL6xMn4S2w'
    OAUTH_TOKEN = '2215957022-yJYGiOTtStOrAyHB7Q6NAJNMbm0YgVD1tXzHKha'
    OAUTH_TOKEN_SECRET = 'hvxFon08v7iKD3bMeZXfge4gU9GuKt6KGA8U743VOTLPb'
    
    auth = twitter.oauth.OAuth(OAUTH_TOKEN, OAUTH_TOKEN_SECRET,
                               CONSUMER_KEY, CONSUMER_SECRET)
    
    twitter_api = twitter.Twitter(auth=auth)
    return twitter_api

def twitter_search(twitter_api, q, mr, max_results=200, **kw):
 
    search_results = twitter_api.search.tweets(q=q, count=100, **kw)
    
    statuses = search_results['statuses']

    
    # Limit on the number of results
    max_results = min(mr, max_results)
    
    for _ in range(10):
        try:
            next_results = search_results['search_metadata']['next_results']
        except KeyError, e: 
            break
            
        # Create a dictionary from next_results
        kwargs = dict([ kv.split('=') 
                        for kv in next_results[1:].split("&") ])
        
        search_results = twitter_api.search.tweets(**kwargs)
        statuses += search_results['statuses']
        
        if len(statuses) > max_results: 
            break
            
    return statuses

def save_json(filename, data):
    with io.open('CrossfitTweets.json'.format(filename), 'w', encoding='utf-8') as f:
        f.write(unicode(json.dumps(data, ensure_ascii=False)))

def load_json(filename):
    with io.open('CrossfitTweets.json'.format(filename), encoding='utf-8') as f:
        return f.read()

q = 'CrossFit'

twitter_api = oauth_login()
results = twitter_search(twitter_api, q, max_results=10)

save_json(q, results)
results = load_json(q)