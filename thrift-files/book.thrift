namespace php Book

struct BookInfo {
1: string name,
2: i64 price,
3: string author
}

service Book {
    BookInfo getBookInfo(1:i32 id);
}
