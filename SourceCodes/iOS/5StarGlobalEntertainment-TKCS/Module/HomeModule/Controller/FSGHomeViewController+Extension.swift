//
//  FSGHomeViewController+Extension.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 25/11/22.
//

import Foundation
import UIKit
import SDWebImage

// MARK: Extension for Home View Controller---
/// manage all the Home Page Detail
extension HomeViewController{
    // MARK: Page Control Action
    /// create a function for control banner with page Control
    /// - Parameter sender: UIPageControl
    @IBAction func pageControlSelectionAction(_ sender: UIPageControl) {
        let page: Int? = sender.currentPage
        var frame: CGRect = self.collectionViewBanner.frame
        frame.origin.x = frame.size.width * CGFloat(page ?? 0)
        frame.origin.y = 0
        self.collectionViewBanner.scrollRectToVisible(frame, animated: true)
    }
    
    func scrollViewDidScroll(_ scrollView: UIScrollView) {
        let offSet = scrollView.contentOffset.x
        let width = scrollView.frame.width
        let horizontalCenter = width / 2

        pageControl.currentPage = Int(offSet + horizontalCenter) / Int(width)
        currentIndex = Int(offSet + horizontalCenter) / Int(width)
    }
    
    // MARK: Create a function for slide banner images in Home Page--
    @objc func slideToNext(){
        guard let count = homeData?.data?.bannerImages?.count else {return}
        //guard let count = homeData?.data?.banner_images?.count else {return}
        if currentIndex < count - 1 {
            currentIndex = currentIndex + 1
            collectionViewBanner.scrollToItem(at:IndexPath(item: currentIndex, section: 0), at: .centeredHorizontally, animated: true)
        }
        else {
            currentIndex = 0
            UIView.animate(withDuration: 0.1, animations: { [weak self] in
                self?.collectionViewBanner.scrollToItem(at: IndexPath(item: self?.currentIndex ?? 0, section: 0), at: .centeredHorizontally, animated: false)
            })
        }
        pageControl.currentPage = currentIndex
    }
    // MARK: Navigate to SideMenu--
    /// Create a function for open a side menu in home page
    /// - Parameter sender: UIButton
    @IBAction func openSideMenu(_ sender: Any) {
        self.present((Common.shared.setMenu()),animated: true)
    }
    // MARK: Search Button Action--
    /// Create a function for search event by title and date
    /// - Parameter sender: UIButton
    @IBAction func SearchButtonAction(_ sender: UIButton){
        let title = self.searchbarTextfield.text ?? DefaultValue.emptyString.rawValue
        let date = self.datetextField.text ?? DefaultValue.emptyString.rawValue
        
        if title != DefaultValue.emptyString.rawValue {
            eventData = homeData?.data?.events?.filter({$0.eventTitle?.lowercased().prefix(title.count) ?? "" == title.lowercased()}) ?? []
            if eventData.count > 0{
                self.labelNoData.isHidden = true
            }else{
                self.labelNoData.isHidden = false
            }
        }
        // MARK: seacrh event through date--
        else if date != DefaultValue.emptyString.rawValue{
            eventData = homeData?.data?.events?.filter({$0.startDate?.lowercased().prefix(date.count) ?? "" >=
                date.lowercased()}) ?? []
            if eventData.count > 0{
                self.labelNoData.isHidden = true
            }else{
                self.labelNoData.isHidden = false
            }
        }
        else{
            eventData = homeData?.data?.events ?? []
        }
        self.eventCatagoryCollectionView.reloadData()
    }
}
// MARK: - Extension for tableview delegate & datasource
extension HomeViewController: UITableViewDelegate, UITableViewDataSource{
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        if homeData?.data?.popularEvents?.count ?? 0 > 0 {
            self.popularEventHeight.constant = CGFloat(150 * Double(homeData?.data?.popularEvents?.count ?? 0))
            return homeData?.data?.popularEvents?.count ?? 0
        }else {
            self.popularEventHeight.constant = CGFloat(150 * Double(homeData?.data?.events?.count ?? 0))
            return homeData?.data?.events?.count ?? 0
        }
    }
    
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        
        let cell = tableView.dequeueReusableCell(withIdentifier: PopularEventTableViewCell.identifier, for: indexPath) as! PopularEventTableViewCell
        if homeData?.data?.popularEvents?.count ?? 0 > 0 {
            if let imageURL = homeData?.data?.popularEvents?[indexPath.row].image{
                let urlString = imageURL.addingPercentEncoding(withAllowedCharacters: .urlQueryAllowed) ?? DefaultValue.emptyString.rawValue
                debugPrint(imageURL)
                cell.popularEventInage.sd_imageIndicator = SDWebImageActivityIndicator.gray
                cell.popularEventInage.sd_setImage(with: URL(string: urlString))
                
            }
        }else{
            if let imageURL = homeData?.data?.events?[indexPath.row].image{
                let urlString = imageURL.addingPercentEncoding(withAllowedCharacters: .urlQueryAllowed) ?? DefaultValue.emptyString.rawValue
                debugPrint(imageURL)
                cell.popularEventInage.sd_imageIndicator = SDWebImageActivityIndicator.gray
                cell.popularEventInage.sd_setImage(with: URL(string: urlString))
                
            }
        }
        return cell
    }
    func tableView(_ tableView: UITableView, heightForRowAt indexPath: IndexPath) -> CGFloat {
        if UIDevice.current.userInterfaceIdiom == .pad {
            return 280
        } else {
            return 150
        }
    }
    func tableView(_ tableView: UITableView, didSelectRowAt indexPath: IndexPath) {
        let vc = self.storyboard?.instantiateViewController(withIdentifier: TicketViewController.identifier)as! TicketViewController
        vc.ticketID = homeData?.data?.events?[indexPath.row].id ?? 0
        self.navigationController?.pushViewController(vc, animated: true)
        debugPrint(DefaultValue.emptyString.rawValue)
        self.eventCatagoryCollectionView.reloadData()
    }
}
// MARK: Extension for textfield delegate--
extension HomeViewController: UITextFieldDelegate{
    @objc func textFiledDidChange(_ textField:UITextField){
        self.setupSelectDate()
    }
}

// MARK: Extension for CollectionView delegate and datasource--
extension HomeViewController:UICollectionViewDelegate, UICollectionViewDataSource, UICollectionViewDelegateFlowLayout{
    func collectionView(_ collectionView: UICollectionView, numberOfItemsInSection section: Int) -> Int {
        switch collectionView{
        case collectionViewBanner:
            return homeData?.data?.bannerImages?.count ?? 0
        case eventCatagoryCollectionView:
            if isAllCategorySelected{
                return  eventData.count
            }else{
                return categorydata?.count ?? 0
            }
        case collectionViewCategorySelection:
            return category.count
            
        default:
            return 0
        }
    }
    func collectionView(_ collectionView: UICollectionView, cellForItemAt indexPath: IndexPath) -> UICollectionViewCell {
        switch collectionView{
            
        case collectionViewBanner:
            let cell = collectionView.dequeueReusableCell(withReuseIdentifier: BannerCollectionViewCell.identifier, for: indexPath) as! BannerCollectionViewCell
            cell.setDescription(description: homeData?.data?.bannerImages?[indexPath.row].description ?? DefaultValue.emptyString.rawValue)
           
            if let imageURL = homeData?.data?.bannerImages?[indexPath.row].bannerImage{
                let urlString = imageURL.addingPercentEncoding(withAllowedCharacters: .urlQueryAllowed) ?? DefaultValue.emptyString.rawValue
                //                debugPrint(imageURL)
                //cell.bannerImage.sd_setShowActivityIndicatorView(true)
                cell.bannerImage.sd_imageIndicator = SDWebImageActivityIndicator.gray
                cell.bannerImage.sd_setImage(with: URL(string: urlString))
                
            }
            else{
                //cell.bannerImage.image =
            }
            return cell
        case eventCatagoryCollectionView:
            let cell = collectionView.dequeueReusableCell(withReuseIdentifier: CatagoryCollectionViewCell.identifier, for: indexPath) as! CatagoryCollectionViewCell
            
            if isAllCategorySelected{
                let data = eventData
                cell.titleLabel.text = data[indexPath.item].eventTitle ?? DefaultValue.emptyString.rawValue
                cell.venueLabel.text = (data[indexPath.item].venue ?? DefaultValue.emptyString.rawValue) + DefaultValue.space.rawValue + (data[indexPath.item].city ?? DefaultValue.emptyString.rawValue)
                let str1 = data[indexPath.item].startDate
                let str2 = data[indexPath.item].endDate
                let date = self.changeDate.getdate(strFirstDate: str1 ?? DefaultValue.emptyString.rawValue, strSecondDate: str2 ?? DefaultValue.emptyString.rawValue)
                cell.dateLabel.text = date
                if let imageURL = data[indexPath.item].image{
                    //                debugPrint(imageURL)
                    let urlString = imageURL.addingPercentEncoding(withAllowedCharacters: .urlQueryAllowed) ?? DefaultValue.emptyString.rawValue
                    cell.catagoryImage.sd_imageIndicator = SDWebImageActivityIndicator.gray
                    cell.catagoryImage.sd_setImage(with: URL(string: urlString)) { reqimage,err,_,url  in
                    }
                }
            }else{
                
                cell.titleLabel.text = categorydata?[indexPath.item].eventTitle ?? DefaultValue.emptyString.rawValue
                cell.venueLabel.text = (categorydata?[indexPath.item].venue ?? DefaultValue.emptyString.rawValue) + DefaultValue.space.rawValue + (categorydata?[indexPath.item].city ?? DefaultValue.emptyString.rawValue)
                let str1 = categorydata?[indexPath.item].startDate
                let str2 = categorydata?[indexPath.item].endDate
                let date = self.changeDate.getdate(strFirstDate: str1 ?? DefaultValue.emptyString.rawValue, strSecondDate: str2 ?? DefaultValue.emptyString.rawValue)
                cell.dateLabel.text = date
                if let imageURL = categorydata?[indexPath.item].image{
                    //                debugPrint(imageURL)
                    let urlString = imageURL.addingPercentEncoding(withAllowedCharacters: .urlQueryAllowed) ?? DefaultValue.emptyString.rawValue
                    cell.catagoryImage.sd_imageIndicator = SDWebImageActivityIndicator.gray
                    cell.catagoryImage.sd_setImage(with: URL(string: urlString)) { reqimage,err,_,url  in
                    }
                }
            }
            
            return cell
            
        case collectionViewCategorySelection:
            let cell = collectionView.dequeueReusableCell(withReuseIdentifier: CategorySelectionViewCell.identifier, for: indexPath) as! CategorySelectionViewCell
            let data = category[indexPath.item]
            cell.lblCategorySelection.text = data
            if indexPath.row == selectedIndexPath{
                cell.viewCategorySelection.layer.backgroundColor = UIColor.white.cgColor
            }else{
                cell.viewCategorySelection.layer.backgroundColor = UIColor.clear.cgColor
            }
            return cell
        default:
            return UICollectionViewCell()
        }
    }
    func collectionView(_ collectionView: UICollectionView, layout collectionViewLayout: UICollectionViewLayout, sizeForItemAt indexPath: IndexPath) -> CGSize {
        switch collectionView{
        case collectionViewBanner:
            return CGSize(width: self
                .collectionViewBanner.frame.width, height: self
                .collectionViewBanner.frame.height)
            
        case eventCatagoryCollectionView:
            if traitCollection.horizontalSizeClass == .regular && traitCollection.verticalSizeClass == .regular{
                if self.eventData.count > 2 {
                    self.collectionViewHCons.constant = 400
                }else{
                    self.collectionViewHCons.constant = 160
                }
                let collectionWidth = eventCatagoryCollectionView.bounds.size.width/3
                return CGSize(width: collectionWidth-10 , height: 190)
            }else{
                if self.eventData.count > 2 {
                    self.collectionViewHCons.constant = 260
                }else{
                    self.collectionViewHCons.constant = 130
                }
                let collectionWidth = eventCatagoryCollectionView.bounds.size.width/2
                return CGSize(width: collectionWidth-10 , height: 120)
            }
            
        case collectionViewCategorySelection:
            let label = UILabel()
            label.text = category[indexPath.item]
            label.sizeToFit()
            return CGSize(width: label.frame.size.width + 20 , height: 25)
        default:
            break
        }
        return CGSize()
    }
    func collectionView(_ collectionView: UICollectionView, didSelectItemAt indexPath: IndexPath) {
        switch collectionView {
        case collectionViewCategorySelection:
            
            switch indexPath.row{
            case 0:
                isAllCategorySelected = true
            default:
                isAllCategorySelected = false
            }
            if isAllCategorySelected{
                if homeData?.data?.events?.count ?? 0 < 1 {
                    labelNoData.isHidden = false
                }else {
                    labelNoData.isHidden = true
                }
                eventData.removeAll()
                if category[indexPath.item] == DefaultValue.all.rawValue {
                    eventData = homeData?.data?.events ?? []
                   // labelNoData.isHidden = true
                }else{
                    catID = homeData?.data?.categories?[indexPath.item - 1].id ?? 0
                    eventData = homeData?.data?.events?.filter({$0.categoryID ?? 0 == catID}) ?? []
                    if eventData.count != 0 {
                        labelNoData.isHidden = true
                    }else{
                        labelNoData.isHidden = false
                    }
                }
                self.eventCatagoryCollectionView.reloadData()
                self.selectedIndexPath = indexPath.item
                self.collectionViewCategorySelection.reloadData()
            }else{
                self.selectedIndexPath = indexPath.item
                self.collectionViewCategorySelection.reloadData()
                let categoryId = homeData?.data?.categories?[indexPath.row - 1].id ?? 0
                self.searchEventByCategoryId(categoryId:categoryId)
            }
        case collectionViewBanner:
            break
            //debugPrint("heloo")
        default:
//            if UserDefaults.standard.value(forKey: Tokenkey.userLogin) as? String ?? "" != ""{
                let vc = self.storyboard?.instantiateViewController(withIdentifier:TicketViewController.identifier)as! TicketViewController
                if isAllCategorySelected{
                    vc.ticketID = eventData[indexPath.item].id ?? 0
                }else{
                    vc.ticketID = categorydata?[indexPath.item].id ?? 0
                    
                }
                self.navigationController?.pushViewController(vc, animated: true)
                debugPrint(DefaultValue.emptyString.rawValue)
                self.eventCatagoryCollectionView.reloadData()
//            }
//            else{
//
//                self.eventCatagoryCollectionView.reloadData()
//            }
            
        }
    }
}
// MARK: Extension SignUpViewController for set date picker--
/// create function for setup date in TextField
/// return : nil
extension HomeViewController{
    func setupSelectDate(){
        if #available(iOS 13.4, *) {
            viewDates.frame = CGRect(x: 0, y: 0, width: self.view.bounds.width, height: 250.0)
            viewDates.frame = CGRect(x: 0, y: 0, width: self.view.bounds.width, height: 250.0)
            // MARK: Date Picker Style--
            if #available(iOS 14.0, *) {
                viewDates.preferredDatePickerStyle = .inline
                viewDates.preferredDatePickerStyle = .inline
            } else {
                // Fallback on earlier versions
            }
        }
        self.viewDates.datePickerMode = .date
        let currentDate = Date()
        var dateComponents = DateComponents()
        let calendar = Calendar.init(identifier: .gregorian)
        dateComponents.year = -100
        let minDate = calendar.date(byAdding: dateComponents, to: currentDate)
        dateComponents.year = 100
        let maxDate = calendar.date(byAdding: dateComponents, to: currentDate)
        viewDates.maximumDate = maxDate
        viewDates.minimumDate = minDate
        self.datetextField.inputView = self.viewDates
        self.datetextField.inputAccessoryView = self.gettoolBar()
    }
    // MARK: ToolBar for Date Picker
    /// create function for date picker style and Size
    /// - Returns: UIToolbar
    func gettoolBar() -> UIToolbar {
        let toolBar = UIToolbar()
        toolBar.barStyle = .default
        toolBar.isTranslucent = true
        let myColor : UIColor = UIColor( red: 2/255, green: 14/255, blue:70/255, alpha: 1.0 )
        toolBar.tintColor = myColor
        toolBar.sizeToFit()
        // Adding Button in ToolBar
        let doneButton = UIBarButtonItem(title: DefaultValue.done.rawValue, style: .plain, target: self, action: #selector(DoneClick))
        let spaceButton = UIBarButtonItem(barButtonSystemItem: .flexibleSpace, target: nil, action: nil)
        let cancelButton = UIBarButtonItem(title: DefaultValue.cancel.rawValue, style: .plain, target: self, action: #selector(CancelClick))
        toolBar.setItems([cancelButton, spaceButton, doneButton], animated: false)
        toolBar.isUserInteractionEnabled = true
        return toolBar
    }
    // MARK: DATE PICKER Done Action
    /// Create function for after done click date show on textfield
    /// return : nil
    @objc func DoneClick() {
        self.view.endEditing(true)
        let dateFormatter = DateFormatter()
        dateFormatter.dateFormat = DefaultValue.inputDateFormat.rawValue
        self.datetextField.text = dateFormatter.string(from: self.viewDates.date)
        self.date = dateFormatter.string(from: viewDates.date)
        let datestr = dateFormatter.date(from: self.date ?? DefaultValue.emptyString.rawValue)
        let dateStamp:TimeInterval = datestr!.timeIntervalSince1970
        self.timeStamp = Int(dateStamp)
    }
    // MARK: Date picker Cancel Action
    /// Create function for date picker cancel to hide date picker
    @objc func CancelClick() {
        self.view.endEditing(true)
    }
}
