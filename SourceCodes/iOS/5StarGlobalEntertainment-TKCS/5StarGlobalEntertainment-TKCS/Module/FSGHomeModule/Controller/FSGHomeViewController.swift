//
//  HomeVC.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 21/11/22.
//

import UIKit

class FSGHomeViewController: UIViewController{
    // MARK: Outlets
    @IBOutlet weak var pageControl: UIPageControl!
    @IBOutlet weak var loginSignUpButton: UIButton!
    @IBOutlet weak var searchBarView: UIView!
    @IBOutlet weak var dateView: UIView!
    @IBOutlet weak var searchButton: UIButton!
    @IBOutlet var buttonUnderline: [UIButton]!
    @IBOutlet weak var datetextField: UITextField!
    @IBOutlet weak var popularEventHeight: NSLayoutConstraint!
    @IBOutlet var buttonSelectCategory: [UIButton]!
    @IBOutlet weak var collectionViewBanner: UICollectionView!
    @IBOutlet weak var eventCatagoryCollectionView: UICollectionView!
    @IBOutlet weak var popularEvenTableView: UITableView!
    // MARK: Variable initializer
    var arrImg = [#imageLiteral(resourceName: "Screenshot 2022-11-21 at 8.19.54 PM"), #imageLiteral(resourceName: "Screenshot 2022-11-17 at 7.53.03 PM"), #imageLiteral(resourceName: "Screenshot 2022-11-17 at 7.55.57 PM"), #imageLiteral(resourceName: "Screenshot 2022-11-21 at 8.19.54 PM")]
    var currentIndex = 0
    var timer:Timer?
    var viewDate = UIDatePicker()
    var timeStamp:Int?
    var date:String?
    // MARK: viewDidLoad--
    override func viewDidLoad() {
        super.viewDidLoad()
        datetextField.delegate = self
        timer = Timer.scheduledTimer(timeInterval: 2.0, target: self, selector: #selector(slideToNext), userInfo: nil, repeats: true)
        pageControl.numberOfPages = arrImg.count
        searchButton.layer.cornerRadius = 10
        loginSignUpButton.layer.cornerRadius = 10
        self.setupSelectDate()
    }

}
