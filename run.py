import os
import requests
import telebot

TOKEN = os.getenv("BOT_TOKEN")

ss, bot = "❤️‍🔥", telebot.TeleBot(TOKEN)

@bot.message_handler(func=lambda message: any(c in message.text for c in ['.', '/']))
def react_to_message(message):
    requests.post(
        f"https://api.telegram.org/bot{bot.token}/setMessageReaction",
        json={
            "chat_id": message.chat.id,
            "message_id": message.message_id,
            "reaction": [{"type": 'emoji', "emoji": ss}]
        }
    )

bot.polling()
