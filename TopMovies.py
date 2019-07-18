# get movies and ratings for top 10 box office movies
# send information to a database
# retrieve and populate website with same information

import mysql.connector
from mysql.connector import Error

try:
    connection = mysql.connector.connect(host='remotemysql.com', database='UO5aMFOKxs', user='UO5aMFOKxs', password='PGGh525shg')

    if connection.is_connected():
        db_Info = connection.get_server_info()
        print("Connected to MySQL database...MySQL Server version on ",db_Info)

except Error as e:
    print("Error while connecting to MySQL", e)


from urllib.request import urlopen as uReq
from bs4 import BeautifulSoup as soup

my_url = 'https://www.rottentomatoes.com/'

my_url2 = 'https://www.imdb.com/search/title/?title='

# opening a connection, grabbing the page
uClient = uReq(my_url)
page_html = uClient.read()
uClient.close()

# html parser
page_soup = soup(page_html, "html.parser")

# grabs each movie
my_table = page_soup.findAll("table",{"class":"movie_list"})
table1 = my_table[3]

# grabs each title
middle = table1.findAll("td", {"class": "middle_col"})

# grabs each score
scores = table1.findAll("td", {"class": "left_col"})

# grabs each amount made
profits = table1.findAll("td", {"class": "right_col"})

id = [1,2,3,4,5,6,7,8,9,10]
top_movies = []
pictures = []
for x in middle:

    title = x.text.strip()

    top_movies.append(title)

    temp_title = title.replace(" ", "%20")

    uClient2 = uReq(my_url2 + temp_title)
    page_html2 = uClient2.read()
    uClient2.close()

    # html parser
    page_soup2 = soup(page_html2, "html.parser")

    # grab movie poster
    my_search_results = page_soup2.findAll("div", {"class": "lister-item mode-advanced"})
    real_result = my_search_results[0]
    movie_number = real_result.div.div['data-tconst']

    my_url3 = 'https://www.imdb.com/title/%s/?ref_=adv_li_tt' % movie_number

    uClient3 = uReq(my_url3)
    page_html3 = uClient3.read()
    uClient3.close()

    # html parser
    page_soup3 = soup(page_html3, "html.parser")

    poster_result = page_soup3.findAll("div", {"class": "poster"})
    poster_temp = poster_result[0]

    poster_link = poster_temp.a['href']

    my_url4 = 'https://www.imdb.com%s' % poster_link

    uClient4 = uReq(my_url4)
    page_html4 = uClient4.read()
    uClient4.close()

    # html parser
    page_soup4 = soup(page_html4, "html.parser")

    movie_posters = page_soup4.findAll("meta", itemprop="image")
    movie_poster = movie_posters[0]
    last_link = movie_poster['content']

    poster = last_link

    pictures.append(poster)

percentage = []
for x in scores:

    score = x.text.strip()

    percentage.append(score)

money = []
for x in profits:

    profit = x.text.strip()

    money.append(profit)

updated = list(zip(top_movies,pictures,percentage,money,id))
print(updated)

if connection.is_connected():
    db_Info = connection.get_server_info()
    print("Connected to MySQL database...MySQL Server version on ", db_Info)
    try:
        cursor = connection.cursor(prepared=True)

        # Update query  rows
        sql_update_query = """Update topMovies set title = %s, poster = %s, percentage = %s, profit = %s where id = %s"""

        # multiple records to be updated in tuple format
        cursor.executemany(sql_update_query, updated)
        connection.commit()
        print(cursor.rowcount, "Records Updated successfully into topMovies table. ")
        print("The Updated count is: ", cursor.rowcount)

    except mysql.connector.Error as error:
        print("Failed to update records to database: {}".format(error))
    finally:
        # closing database connection.
        if (connection.is_connected()):
            connection.close()
            print("connection is closed")