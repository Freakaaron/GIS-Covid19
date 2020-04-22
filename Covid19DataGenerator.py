def generate_sql(file):
    output_file = open("data/covid.sql", "w")
    count = 0
    while True:
        line = file.readline()
        line = line.replace("'", "''")
        if line != '':
            tokens = line.split(",")
            if count > 1 and count != 61971:
                output_file.write("\nINSERT INTO covid(case_date, county, state, cases, deaths) VALUES('" + tokens[0]
                                  + "', '" + tokens[1]
                                  + "', '" + tokens[2]
                                  + "', " + tokens[4]
                                  + ", " + tokens[5][:len(tokens[5]) - 1]
                                  + ");")
            elif count == 1:
                output_file.write("INSERT INTO covid(case_date, county, state, cases, deaths) VALUES('" + tokens[0]
                                  + "', '" + tokens[1]
                                  + "', '" + tokens[2]
                                  + "', " + tokens[4]
                                  + ", " + tokens[5][:len(tokens[5]) - 1]
                                  + ");")
            elif count == 61971:
                output_file.write("\nINSERT INTO covid(case_date, county, state, cases, deaths) VALUES('" + tokens[0]
                                  + "', '" + tokens[1]
                                  + "', '" + tokens[2]
                                  + "', " + tokens[4]
                                  + ", " + tokens[5]
                                  + ");")
            count += 1
        else:
            output_file.close()
            return


if __name__ == "__main__":
    try:
        file = open("covid-19_data.txt")
        generate_sql(file)
    except:
        print("The file name does not exist")