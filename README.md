# WP Book Plugin

A plugin for book management which includes a bunch of useful and productive features like shortcode, dashboard widget, sidebar widget, book info autofill, currency conversion forex rate table etc.

On the top of all this I've tried to make it as secure as possible using sanitization, escape and validation functions.

As well as, to connect with the user, used internationalization function to easily translate to any local language of the user liking.

## Prerequisites

1. Make sure to change permalink setting of wordpress to http://example.com/%postname%/
2. Use a theme with sidebar options in it for widget area , I suggest [Themify Simple](https://themify.me/themes/simple)
3. An active internet connection.

## Suggestions

1. Please avoid using special characters such as @, &, ` etc. while naming categories and tags as wordpress gutenberg editor html escapes those characters and may hinder in search results while using shortcodes.

## Features

1. 'Book' custom post type, 'Book Category' Heirarchical Taxonomy and 'Book Tag' Non-Heirarchical Taxonomy
2. A custom meta box to save book meta information like Author, Publish Year, Price, Publisher, Edition, Book URL, No. of Pages, Description,Rating, Language, Category and Tag.
3. A search & autofill meta box to search book title and autofill the meta fields using a [Google Books API](https://developers.google.com/books/docs/overview) as a trusted source.
4. 'wpbk_bookmeta' table to save book meta information.
5. A custom 'settings' submenu page under 'Books' menu to manage books accessibility and currency related settings.
6. A forex rate table to easily to convert prices and manage custom forex rates and get forex rates from [Exchangerate.host API](https://exchangerate.host/#/).
7. A shortcode 'book' to easily search and get books of a certain taste.
8. A 'WP Book Category Widget' sidebar widget to display books of selected category in frontend.
9. A 'Top 5 Book Categories' dashboard widget to display top 5 book categories with maximum posts
10. Deactivation and Uninstall hooks for thorough and proper deactivation and uninstallation ( with db cleanup) process.

## Usage

Usage documentation of some features in WP Book plugin.

### Book Search and Autofill Metabox

It Uses Google Books API to fetch book information like Author, Publish Year, Publisher, Edition, Book URL, No. of Pages, Description, Rating and Language.

In addition to that it also suggests book category as 'Suggested Category' and book thumbnail as 'Thumbnail URL' in 'Book Information' metabox 
Suggested fields will not be saved , they are just mere suggestions.

Steps to use :

1. Click on 'Search & Autofill Book Information' tab in post create or edit page
2. Check 'Autofill the Book Information' Checkbox
3. Enter the title of book in search book field
4. Click Search
5. Select a radio button with desired book title 
6. Click on 'Autofill' button at bottom of the list
7. Done ! See the bookmeta fields filled with content

### Shortcode : book

[book id=' 3, 5, 6 ' author_name=' Lisa S. Brenner, Jo Duffy ' year=' 2018, 1982 ' publisher=' McFarland, Scholastic ' category=' Fiction, Adventure ' tag=' #harrypotter, #dolittle ']

OR

[book id=' 3 ' author_name=" Bre'z Burner, Jo Duffy " year=' 2018 ' publisher=' McFarland, Scholastic ' category=' Fiction, Adventure ' tag=' #dolittle ']

Parameters :

- id          : Book Id(s)
- author_name : Book Author Name(s)
- year        : Book Publish Year(s)
- publisher   : Book Publisher Name(s)
- category    : Book Category(ies)
- tag         : Book tag(s)

Care to be Taken :

- Avoid using special characters such as @, &, ` etc. as wordpress gutenberg editor html escapes those characters
- Atleast one parameter is required.
- Input Parameters are case sensitive
- Only 'author_name' compares with LIKE clause , so 'Lisa' will return 'Lisa S. Brenner' in result.
- Parameter with an ' (Single Quote) as an input should be enclosed within a " (Double Quotes).
- Each parameter can be used as comma seperated value to search multiple strings in a book attribute.
- All these parameters are in 'AND' relationship with each other & 'OR' relationship applies for a particular attribute with comma separated string as an input.

So, [book id=' 3 ' author_name=" Bre'z Burner, Jo Duffy "] translates to "where book id is 3 and author name is like Bre'z Burner or Jo Duffy".

### Book Accessibility Settings

Book Accessibility settings include 'No. of Books per page' and 'Choose Book Information to Display'.

1. No. of Books per page : Number of books to display on listing page.

2. Choose Book Information to Display : Bookmeta attributes to display along with content and in shortcode.

- Author Name  : Name of the book author(s)
- Publish Year : Publish year of book
- Price        : Price of the book
- Publisher    : Publisher(s) of the book
- Edition      : Edition of the book
- Book URL     : URL of the book
- No. of Pages : Number of pages in the book
- Description  : Short description of the book
- Rating       : Rating of the book
- Language     : book's language(s)
- Category     : Category(s) of the book
- Tag          : Tag(s) of the book

### Book Currency Settings

Book currency settings include 'Base Currency', ' Recalculate ' , "Site's Display Currency Unit" , "Site's Display Currency FX Rate Type" and 'Forex Rate Table'.

1. Base Currency : book price base currency of your website

2. Recalculate :
- Whenever the base currency is changed the books prices that are already saved in the database required to be updated.
- This can be done by using recalculate link available upon changing base currency.

Steps to use :
- Just simply check the 'Recalculate saved book Prices ::' checkbox
- Choose conversion FX rate type 
- Then click on the recalculate link 
- Wait for a little bit and voila !

Care to be taken :
- Once started it should not be interrupted.
- Once completed save the settings to avoid any type of misinformation.

3. Site's Display Currency Unit : Currency to display on your website , Does not affect the database.

4. Site's Display Currency FX Rate Type : FX rate used to convert the choosen display currency.

5. Forex Rate Table :
- Manages user defined & API generated forex rates.
- To manually update API generated forex rate , click on little update button , located just beside the 'API Currency Rate' column in the table (by Default it is maintained for a week).


# Dsignfly Theme

A beautiful theme to manage and organize portfolios, packed with bunch of productive features such as custom theme customizer, image slider, custom sidebar area, widgets of social media, recent, related, popular and portfolio posts etc.

## Prerequisites

1. Make sure to change permalink setting of wordpress to http://example.com/%postname%/

## Note 

1. Dsignfly theme is not responsive, it is tested for screen size of ' 1920 x 1080 '.

2. Dsignfly theme also includes some preloaded content for easy and hasselfree setup of theme testing environment. However these content are included solely for the purpose of reducing manual efforts to evaluate the theme.

3. Dsignfly theme is configured only to show the "dsign_portfolio" post type posts.

## Theme includes :

1.  Home Page
2.  Blog Page
3.  Portfolio Page
4.  Single Post Page
5.  Search Page
6.  Archive Page ( Category Page, Author Page, Tags Page )
7.  Dsignfly Dynamic Sidebar
8.  Social Media Widget ( Facebook, Twitter )
9.  Posts Widget ( Related, Portfolio, Recent & Popular Posts Widget )
10. Theme Customizer Settings
11. Custom Styled Comments & Comment Form
12. Custom Post Type ( ' dsign_portfolio ' )
13. Custom Taxonomies ( ' dsign_portfolio_category, dsign_portfolio_tag ' )
14. Custom Pagination Bar.

## Developer Information :

Virag Vaghasiya
- A Magento developer and a WordPress enthusiast.

Contact Details :
- Email : viragvaghasiya@gmail.com
