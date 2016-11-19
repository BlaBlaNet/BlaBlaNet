[table]
[tr][th]Field[/th][th]Description[/th][th]Type[/th][th]Null[/th][th]Key[/th][th]Default[/th][th]Extra
[/th][/tr]
[tr][td]chat_id[/td][td]sequential ID[/td][td]int(10) unsigned[/td][td]NO[/td][td]PRI[/td][td]NULL[/td][td]auto_increment
[/td][/tr]
[tr][td]chat_room[/td][td]chatroom.cr_id for this chat[/td][td]int(10) unsigned[/td][td]NO[/td][td]MUL[/td][td]0[/td][td]
[/td][/tr]
[tr][td]chat_xchan[/td][td]author xchan_hash[/td][td]char(255)[/td][td]NO[/td][td]MUL[/td][td][/td][td]
[/td][/tr]
[tr][td]chat_text[/td][td]the text of the chat message[/td][td]mediumtext[/td][td]NO[/td][td][/td][td]NULL[/td][td]
[/td][/tr]
[tr][td]created[/td][td]timestamp of this message[/td][td]datetime[/td][td]NO[/td][td]MUL[/td][td]0000-00-00 00:00:00[/td][td]
[/td][/tr]
[/table]

Return to [zrl=[baseurl]/help/database]database documentation[/zrl]