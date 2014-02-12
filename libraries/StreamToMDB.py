import tweepy
import json
import pymongo
import time

CONSUMER_KEY='XXgXT3xLUOV9VfyZIHkZw'
CONSUMER_SECRET='KtZ2QkB7bHDEAf4A01uVA5XQGkMc3k4UjL6xMn4S2w'
OAUTH_TOKEN='2215957022-yJYGiOTtStOrAyHB7Q6NAJNMbm0YgVD1tXzHKha'
OAUTH_TOKEN_SECRET='hvxFon08v7iKD3bMeZXfge4gU9GuKt6KGA8U743VOTLPb'

auth=tweepy.OAuthHandler(CONSUMER_KEY, CONSUMER_SECRET)
auth.set_access_token(OAUTH_TOKEN, OAUTH_TOKEN_SECRET)
api = tweepy.API(auth)

uk = [-9, 48, 2, 58]
    
class listener(tweepy.StreamListener):
	
	
	def __init__(self, api):
		self.api = api
		self.counter = 0
		super(tweepy.StreamListener, self).__init__()
		
		self.db = pymongo.MongoClient().test
		
	def on_data(self, tweet):
		self.db.tweets.insert(json.loads(tweet))
		self.counter = self.counter + 1
		print self.counter
		if self.counter > 20:
			return False
		else:
			return True

		
	def on_error(self, status_code):
		return True
		
	def on_timeout(self):
		return True
		
	


twitterStream=tweepy.streaming.Stream(auth, listener(api))
twitterStream.filter(track = ["Olympics"], locations = uk, languages = ['en']) 
