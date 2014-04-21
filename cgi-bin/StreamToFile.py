import tweepy
import json
import pymongo
import time
import re

CONSUMER_KEY='XXgXT3xLUOV9VfyZIHkZw'
CONSUMER_SECRET='KtZ2QkB7bHDEAf4A01uVA5XQGkMc3k4UjL6xMn4S2w'
OAUTH_TOKEN='2215957022-yJYGiOTtStOrAyHB7Q6NAJNMbm0YgVD1tXzHKha'
OAUTH_TOKEN_SECRET='hvxFon08v7iKD3bMeZXfge4gU9GuKt6KGA8U743VOTLPb'

auth=tweepy.OAuthHandler(CONSUMER_KEY, CONSUMER_SECRET)
auth.set_access_token(OAUTH_TOKEN, OAUTH_TOKEN_SECRET)
api = tweepy.API(auth)
    
class listener(tweepy.StreamListener):
	
	
	def __init__(self, api):
		self.api = api
		self.counter = 0
		super(tweepy.StreamListener, self).__init__()
		
		self.db = pymongo.MongoClient().test
		
			
	def on_data(self, tweet):
		#Add tweet to tweet database
		self.db.tweets.insert(json.loads(tweet))
		
		#Adding 1 to the total number of tweets collected
		self.counter = self.counter + 1
		
		#Parse and strip the text entity within the tweet
		decoded = json.loads(tweet)
		text = decoded['text'].encode('ascii', 'ignore')
		text = text.lower()
		text = re.sub('((www\.[\s]+)|(https?://[^\s]+))','URL',text)
		text = re.sub('@[^\s]+','AT_USER',text)
		text = re.sub('[\s]+', ' ', text)
		text = re.sub(r'#([^\s]+)', r'\1', text)
		text = text.strip('\'"')
		
		#Positive file opening and appending to list
		pos_file = open('positive.txt', 'r')
		positive = [line.strip() for line in pos_file]
		pos = []
		for line in positive:
			pos.append(line)
			pos_file.close()
			
		#Negative file opening and appending to list
		neg_file = open('negative.txt', 'r')
		negative = [line.strip() for line in neg_file]
		neg = []
		for line in negative:
			neg.append(line)
			neg_file.close()			
		
		#Creating a list of the words in the Tweets text entity, post stripping
		words = []		
		for i in text:
			if i.isalnum() or i.isspace():
				words.append(i)
			else:
				words.append(' ')
		tweet_words = "".join(words)
		words_list = tweet_words.split()
		
		#Identifying what words within the positive file are also in the twweets text
		pos_words = list(set(pos) & set(words_list))
		
		#Identifying what words within the positive file are also in the twweets text
		neg_words = list(set(neg) & set(words_list))
		
		#Positive and Negative word score to calculate tweet sentiment
		pos_sent = len(pos_words)
		neg_sent = len(neg_words)
		
		#Tweets unique id and sentiment score stored within the MongoDB
		id = decoded['id_str']
		sent_score = pos_sent - neg_sent
		tweet_sent = {"id_str": id, "sent_score": sent_score}
		self.db.sentiment.insert(tweet_sent)
		
		
		#When the counter reaches required number of tweets to be collected, the script it terminated
		if self.counter > 2000:
			return False
		else:
			return True

		
	def on_error(self, status_code):
		return True
		
	def on_timeout(self):
		return True
		
	def on_disconnect(self, notice):
		return True

twitterStream=tweepy.streaming.Stream(auth, listener(api))
twitterStream.filter(track=['easter'], languages = ['en'])
