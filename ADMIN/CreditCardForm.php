<?php
include '../DBConnection/dbconnection.php';
$Qty = $_GET['qty'];
$Price = $_GET['price'];
$Sid = $_GET['sid'];
$Pid = $_GET['pid'];
$Stock = $_GET['stock'];
$Total = $Price * $Qty;
$UpdatedQty = $Stock - $Qty;
// echo $UpdatedQty;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Credit Card Form</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css" />
  <link rel="stylesheet" href="payment.css" />
  <script src="./payment.js" type="text/javascript"></script>
</head>

<body>
  <!-- partial:index.partial.html -->
  <div class="wrapper" id="app">
    <div class="card-form">
      <div class="card-list">
        <div class="card-item" v-bind:class="{ '-active' : isCardFlipped }">
          <div class="card-item__side -front">
            <div class="card-item__focus" v-bind:class="{'-active' : focusElementStyle }" v-bind:style="focusElementStyle" ref="focusElement"></div>
            <div class="card-item__cover">
              <img v-bind:src="'https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/' + currentCardBackground + '.jpeg'" class="card-item__bg" />
            </div>

            <div class="card-item__wrapper">
              <div class="card-item__top">
                <img src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/chip.png" class="card-item__chip" />
                <div class="card-item__type">
                  <transition name="slide-fade-up">
                    <img v-bind:src="'https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/' + getCardType + '.png'" v-if="getCardType" v-bind:key="getCardType" alt="" class="card-item__typeImg" />
                  </transition>
                </div>
              </div>
              <label for="cardNumber" class="card-item__number" ref="cardNumber">
                <template v-if="getCardType === 'amex'">
                  <span v-for="(n, $index) in amexCardMask" :key="$index">
                    <transition name="slide-fade-up">
                      <div class="card-item__numberItem" v-if="$index > 4 && $index < 14 && cardNumber.length > $index && n.trim() !== ''">
                        *
                      </div>
                      <div class="card-item__numberItem" :class="{ '-active' : n.trim() === '' }" :key="$index" v-else-if="cardNumber.length > $index">
                        {{cardNumber[$index]}}
                      </div>
                      <div class="card-item__numberItem" :class="{ '-active' : n.trim() === '' }" v-else :key="$index + 1">
                        {{n}}
                      </div>
                    </transition>
                  </span>
                </template>

                <template v-else>
                  <span v-for="(n, $index) in otherCardMask" :key="$index">
                    <transition name="slide-fade-up">
                      <div class="card-item__numberItem" v-if="$index > 4 && $index < 15 && cardNumber.length > $index && n.trim() !== ''">
                        *
                      </div>
                      <div class="card-item__numberItem" :class="{ '-active' : n.trim() === '' }" :key="$index" v-else-if="cardNumber.length > $index">
                        {{cardNumber[$index]}}
                      </div>
                      <div class="card-item__numberItem" :class="{ '-active' : n.trim() === '' }" v-else :key="$index + 1">
                        {{n}}
                      </div>
                    </transition>
                  </span>
                </template>
              </label>
              <div class="card-item__content">
                <label for="cardName" class="card-item__info" ref="cardName">
                  <div class="card-item__holder">Card Holder</div>
                  <transition name="slide-fade-up">
                    <div class="card-item__name" v-if="cardName.length" key="1">
                      <transition-group name="slide-fade-right">
                        <span class="card-item__nameItem" v-for="(n, $index) in cardName.replace(/\s\s+/g, ' ')" v-if="$index === $index" v-bind:key="$index + 1">{{n}}</span>
                      </transition-group>
                    </div>
                    <div class="card-item__name" v-else key="2">
                      Full Name
                    </div>
                  </transition>
                </label>
                <div class="card-item__date" ref="cardDate">
                  <label for="cardMonth" class="card-item__dateTitle">Expires</label>
                  <label for="cardMonth" class="card-item__dateItem">
                    <transition name="slide-fade-up">
                      <span v-if="cardMonth" v-bind:key="cardMonth">{{cardMonth}}</span>
                      <span v-else key="2">MM</span>
                    </transition>
                  </label>
                  /
                  <label for="cardYear" class="card-item__dateItem">
                    <transition name="slide-fade-up">
                      <span v-if="cardYear" v-bind:key="cardYear">{{String(cardYear).slice(2,4)}}</span>
                      <span v-else key="2">YY</span>
                    </transition>
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="card-item__side -back">
            <div class="card-item__cover">
              <img v-bind:src="'https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/' + currentCardBackground + '.jpeg'" class="card-item__bg" />
            </div>
            <div class="card-item__band"></div>
            <div class="card-item__cvv">
              <div class="card-item__cvvTitle">CVV</div>
              <div class="card-item__cvvBand">
                <span v-for="(n, $index) in cardCvv" :key="$index"> * </span>
              </div>
              <div class="card-item__type">
                <img v-bind:src="'https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/' + getCardType + '.png'" v-if="getCardType" class="card-item__typeImg" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <form action="" method="post">
        <div class="card-form__inner">
          <div class="card-input">
            <label for="cardNumber" class="card-input__label">Card Number</label>
            <input type="text" id="cardNumber" class="card-input__input" v-mask="generateCardNumberMask" v-model="cardNumber" v-on:focus="focusInput" v-on:blur="blurInput" data-ref="cardNumber" autocomplete="off" required />
          </div>
          <div class="card-input">
            <label for="cardName" class="card-input__label">Card Holders</label>
            <input type="text" id="cardName" class="card-input__input" v-model="cardName" v-on:focus="focusInput" v-on:blur="blurInput" data-ref="cardName" autocomplete="off" required />
          </div>
          <div class="card-form__row">
            <div class="card-form__col">
              <div class="card-form__group">
                <label for="cardMonth" class="card-input__label">Expiration Date</label>
                <select class="card-input__input -select" id="cardMonth" v-model="cardMonth" v-on:focus="focusInput" v-on:blur="blurInput" data-ref="cardDate" required>
                  <option value="" disabled selected>Month</option>
                  <option v-bind:value="n < 10 ? '0' + n : n" v-for="n in 12" v-bind:disabled="n < minCardMonth" v-bind:key="n">
                    {{n < 10 ? '0' + n : n}}
                  </option>
                </select>
                <select class="card-input__input -select" id="cardYear" v-model="cardYear" v-on:focus="focusInput" v-on:blur="blurInput" data-ref="cardDate" required>
                  <option value="" disabled selected>Year</option>
                  <option v-bind:value="$index + minCardYear" v-for="(n, $index) in 12" v-bind:key="n">
                    {{$index + minCardYear}}
                  </option>
                </select>
              </div>
            </div>
            <div class="card-form__col -cvv">
              <div class="card-input">
                <label for="cardCvv" class="card-input__label">CVV</label>
                <input type="text" class="card-input__input" id="cardCvv" v-mask="'####'" maxlength="3" v-model="cardCvv" v-on:focus="flipCard(true)" v-on:blur="flipCard(false)" autocomplete="off" required />
              </div>
            </div>
          </div>
          <button class="card-form__button" type="submit" name="payNow">&#8377;
            <?php echo $Total ?>
          </button>
        </div>
      </form>
    </div>
  </div>
  <!-- partial -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
  <script src="https://unpkg.com/vue-the-mask@0.11.1/dist/vue-the-mask.js"></script>
  <script>
    new Vue({
      el: "#app",
      data() {
        return {
          currentCardBackground: Math.floor(Math.random() * 25 + 1), // just for fun :D
          cardName: "",
          cardNumber: "",
          cardMonth: "",
          cardYear: "",
          cardCvv: "",
          minCardYear: new Date().getFullYear(),
          amexCardMask: "#### ###### #####",
          otherCardMask: "#### #### #### ####",
          cardNumberTemp: "",
          isCardFlipped: false,
          focusElementStyle: null,
          isInputFocused: false,
        };
      },
      mounted() {
        this.cardNumberTemp = this.otherCardMask;
        document.getElementById("cardNumber").focus();
      },
      computed: {
        getCardType() {
          let number = this.cardNumber;
          let re = new RegExp("^4");
          if (number.match(re) != null) return "visa";

          re = new RegExp("^(34|37)");
          if (number.match(re) != null) return "amex";

          re = new RegExp("^5[1-5]");
          if (number.match(re) != null) return "mastercard";

          re = new RegExp("^6011");
          if (number.match(re) != null) return "discover";

          re = new RegExp("^9792");
          if (number.match(re) != null) return "troy";

          return "visa"; // default type
        },
        generateCardNumberMask() {
          return this.getCardType === "amex" ?
            this.amexCardMask :
            this.otherCardMask;
        },
        minCardMonth() {
          if (this.cardYear === this.minCardYear)
            return new Date().getMonth() + 1;
          return 1;
        },
      },
      watch: {
        cardYear() {
          if (this.cardMonth < this.minCardMonth) {
            this.cardMonth = "";
          }
        },
      },
      methods: {
        flipCard(status) {
          this.isCardFlipped = status;
        },
        focusInput(e) {
          this.isInputFocused = true;
          let targetRef = e.target.dataset.ref;
          let target = this.$refs[targetRef];
          this.focusElementStyle = {
            width: `${target.offsetWidth}px`,
            height: `${target.offsetHeight}px`,
            transform: `translateX(${target.offsetLeft}px) translateY(${target.offsetTop}px)`,
          };
        },
        blurInput() {
          let vm = this;
          setTimeout(() => {
            if (!vm.isInputFocused) {
              vm.focusElementStyle = null;
            }
          }, 300);
          vm.isInputFocused = false;
        },
      },
    });
  </script>

</body>

</html>

<?php
if (isset($_REQUEST['payNow'])) {
  $qryCheck = "SELECT * FROM `inventory` WHERE `pdt_id`='$Pid' AND `sid`='$Sid'";
  $resultCheck = $conn->query($qryCheck);

  if ($resultCheck->num_rows > 0) {
    $qry = "UPDATE `product` SET `stock`='$UpdatedQty' WHERE `pdt_id`='$Pid'";
    $qry1 = "UPDATE `inventory` SET `stock`=`stock` + '$Qty' WHERE `pdt_id`='$Pid'";
    if ($conn->query($qry) === TRUE && $conn->query($qry1) === TRUE) {
      echo "<script>alert('Successfully Paid'); window.location = 'adminViewInventory.php';</script>";
    } else {
      $error_message = "Error updating payment status: " . mysqli_error($conn);
      echo "<script>alert('$error_message');</script>";
    }
  } else {
    $qry = "UPDATE `product` SET `stock`='$UpdatedQty' WHERE `pdt_id`='$Pid'";
    $qry1 = "INSERT INTO `inventory` (`pdt_id`,`sid`,`stock`,`total`) VALUES('$Pid','$Sid','$Qty','$Total') ";
    if ($conn->query($qry) === TRUE && $conn->query($qry1) === TRUE) {
      echo "<script>alert('Successfully Paid'); window.location = 'adminViewInventory.php';</script>";
    } else {
      $error_message = "Error updating payment status: " . mysqli_error($conn);
      echo "<script>alert('$error_message');</script>";
    }
  }
}
?>

<!-- if (isset($_REQUEST['payNow'])) {
    $qryCheck = "SELECT * FROM `inventory` WHERE `pdt_id`='$Pid' AND `sid`='$Sid'";
    $resultCheck = $conn->query($qryCheck);

    if ($resultCheck->num_rows > 0) {
        // Item already exists, perform update
        $row = $resultCheck->fetch_assoc();
        $newStock = $row['stock'] + $Qty;
        $newTotal = $row['total'] + $Total;

        $qryUpdate = "UPDATE `inventory` SET `stock`='$newStock', `total`='$newTotal' WHERE `pdt_id`='$Pid' AND `sid`='$Sid'";
        if ($conn->query($qryUpdate) === TRUE) {
            echo "<script>alert('Successfully Paid'); window.location = 'adminViewInventory.php';</script>";
        } else {
            $error_message = "Error updating payment status: " . mysqli_error($conn);
            echo "<script>alert('$error_message');</script>";
        }
    } else {
        // Item does not exist, perform insert
        $qryInsert = "INSERT INTO `inventory` (`pdt_id`,`sid`,`stock`,`total`) VALUES('$Pid','$Sid','$Qty','$Total')";
        if ($conn->query($qryInsert) === TRUE) {
            echo "<script>alert('Successfully Paid'); window.location = 'adminViewInventory.php';</script>";
        } else {
            $error_message = "Error updating payment status: " . mysqli_error($conn);
            echo "<script>alert('$error_message');</script>";
        }
    }
} -->