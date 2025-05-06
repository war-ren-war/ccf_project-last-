from flask import Flask, request, render_template, redirect, url_for, session, jsonify
import pymysql
import bcrypt

app = Flask(__name__)
app.secret_key = "my_secret_key"

# MariaDB connection details
db = pymysql.connect(
    host="localhost",
    user="root",
    password="",           # update if your MariaDB has a password
    database="ccf_users2",
    cursorclass=pymysql.cursors.DictCursor
)

@app.route("/", methods=["GET", "POST"])
def login():
    if request.method == "POST":
        username = request.form["username"]
        password = request.form["password"].encode("utf-8")

        with db.cursor() as cursor:
            cursor.execute("SELECT * FROM users WHERE username = %s", (username,))
            user = cursor.fetchone()

            if user and bcrypt.checkpw(password, user["password"].encode("utf-8")):
                session["user_id"] = user["id"]
                return redirect(url_for("dashboard"))
            else:
                return "Invalid username or password", 401

    return '''
        <form method="post">
            Username: <input name="username"><br>
            Password: <input name="password" type="password"><br>
            <input type="submit" value="Login">
        </form>
    '''

@app.route("/dashboard")
def dashboard():
    if "user_id" not in session:
        return redirect(url_for("login"))
    return render_template("dashboard.html")

@app.route("/profile.php")
def profile():
    if "user_id" not in session:
        return jsonify({"error": "Not logged in"}), 403

    with db.cursor() as cursor:
        cursor.execute("SELECT * FROM users WHERE id = %s", (session["user_id"],))
        user = cursor.fetchone()

    if not user:
        return jsonify({"error": "User not found"}), 404

    # Format fields for JSON (matching your HTML IDs)
    return jsonify({
        "fullname": f"{user['first_name']} {user['last_name']}",
        "nickname": user["nickname"],
        "username": user["username"],
        "email": user["email"],
        "gender": user["gender"],
        "birthday": f"{user['birth_month']} {user['birth_year']}",
        "life_stage": user["life_stage"],
        "contact": user["mobile_number"],
        "country": user["country"],
        "region": user["region"],
        "city": user["city"],
        "glc_id": user["glc_id"],
        "occupation": user["occupation"],
        "industry": user["industry"],
        "purpose": user["purpose"],
        "church": user["ccf_satellite"],
        "worship_place": user["place_of_worship"],
        "worship_day": user["worship_day"],
        "worship_time": user["worship_time"],
        "since": user["year_started"],
        "pastor": user["pastor"],
        "image_url": "/static/default-user.png"  # Add image URL logic if needed
    })

if __name__ == "__main__":
    app.run(debug=True)
